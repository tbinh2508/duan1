<?php

namespace App\Http\Controllers\Client;

use App\Events\SendMailOrderEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Mail\OrderMailController;
use App\Http\Requests\CheckOutRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\VnpayPayment;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $cartService;
    public function __construct(
        CartService $cartService
    ) {
        $this->cartService = $cartService;
    }
public function checkout()
    {
        $productVariants = $this->cartService->showProductVariantsCartCheckout();
        if (!$productVariants) {
            return back()->with('error', 'Vui lòng chọn sản phẩm trong giỏ hàng !!!');
        }
        $totals = 0;
        $carts = Cart::with('cartItems.productVariant.product')->where('user_id', Auth::user()->id)->first();
        foreach ($carts->cartItems ?? [] as $cart) {
            if ($cart->is_check) {
                $totals += ($cart->quantity * ($cart->productVariant->product->price_sale ? $cart->productVariant->product->price_sale : $cart->productVariant->product->price_regular));
            }
        }

        return view('client.checkout', compact('productVariants', 'totals'));
    }   


    public function listorders()
    {
        $listOrders  = Order::with('orderItems', 'user')->where('user_id', Auth::user()->id)->latest('id')->paginate(5);
        return view('client.order', compact('listOrders'));
    }
    public function showOrders(string $id)
    {
        $data = Order::with('orderItems', 'user')->findOrFail($id);

        return view('client.show', compact('data'));
    }
    public function ordersCancel(Request $request, string $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $order = Order::with('orderItems', 'user')->findOrFail($id);
                if ($request->status_order === STATUS_ORDER_PENDING) {
                    $order->update([
                        'status_order' => STATUS_ORDER_CANCELED
                    ]);
                }
                $productVarriant = ProductVariant::query()->get();
                foreach ($productVarriant as $item) {
                    foreach ($order->orderItems as $value) {
                        if ($value->product_variant_id == $item->id) {
                            $item->update([
                                'quantity' => $item->quantity + $value->order_item_quantity
                            ]);
                        }
                    }
                }
            });
            return redirect()->route('listorders')->with('success', 'Hủy thành công !!!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Hủy không thành công !!!');
        }
    }

    // public function execPostRequest($url, $data)
    // {
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt(
    //         $ch,
    //         CURLOPT_HTTPHEADER,
    //         array(
    //             'Content-Type: application/json',
    //             'Content-Length: ' . strlen($data)
    //         )
    //     );
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //     //execute post
    //     $result = curl_exec($ch);
    //     //close connection
    //     curl_close($ch);
    //     return $result;
    // }
    // private function processPayment($dataRequest)
    // {
    //     Log::info('momo');
    //     $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    //     $partnerCode = 'MOMOBKUN20180529';
    //     $accessKey = 'klm05TvNBzhg7h7j';
    //     $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    //     $orderInfo = "Thanh toán qua MoMo";
    //     $orderId = $dataRequest['order_id'];
    //     $redirectUrl = env('APP_URL') . '/thankyoupayment';
    //     $ipnUrl = "https://hehe.test/check-out";
    //     $extraData = "";

    //     $requestId = time() . "";
    //     $requestType = "payWithATM";

    //     $rawHash = "accessKey=" . $accessKey . "&amount=" .  $dataRequest['order_total_price'] . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType ;
    //     $signature = hash_hmac("sha256", $rawHash, $secretKey);

    //     $data = [
    //         'partnerCode' => $partnerCode,
    //         'partnerName' => "Test",
    //         "storeId" => "MomoTestStore",
    //         'requestId' => $requestId,
    //         'amount' => $dataRequest['order_total_price'],
    //         'orderId' => $orderId,
    //         'orderInfo' => $orderInfo,
    //         'redirectUrl' => $redirectUrl,
    //         'ipnUrl' => $ipnUrl,
    //         'lang' => 'vi',
    //         'extraData' => $extraData,
    //         'requestType' => $requestType,
    //         'signature' => $signature
    //     ];

    //     $result = $this->execPostRequest($endpoint, json_encode($data));

    //     $jsonResult = json_decode($result, true);

    //     if (!isset($jsonResult['payUrl'])) {
    //         return null;
    //     }

    //     // Redis::setex("order:$orderId", 900, json_encode([
    //     //     'order_id' => $orderId,
    //     //     'data' => $dataRequest,
    //     // ]));
    //     Log::info($jsonResult['payUrl']);
    //     return redirect()->to($jsonResult['payUrl']);
    // }
    public function execPostRequest($url, $dataJson)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $dataJson,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $result = curl_exec($ch);
        if ($result === false) {
            Log::error('MoMo CURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    private function processPayment($dataRequest)
    {
        Log::info('momo');

        $endpoint    = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey   = 'klm05TvNBzhg7h7j';
        $secretKey   = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $amount      = (string) intval($dataRequest['order_total_price']);
        $orderDbId   = (string) $dataRequest['order_id'];

        // ✅ orderId duy nhất cho MoMo (a-zA-Z0-9, dấu gạch dưới, độ dài <= 50)
        $orderId     = $orderDbId . '-' . now()->format('YmdHis');

        $orderInfo   = "Thanh toán qua MoMo";
        $redirectUrl = rtrim(env('APP_URL'), '/') . '/thankyoupayment';
        $ipnUrl      = rtrim(env('APP_URL'), '/') . '/momo/ipn';
        $requestId   = (string) time();
        $requestType = "payWithATM";

        // ✅ Nhét id gốc để đối soát
        $extraData   = base64_encode(json_encode(['order_id' => $orderDbId]));

        $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $payload = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId'     => "MomoTestStore",
            'requestId'   => $requestId,
            'amount'      => $amount,
            'orderId'     => $orderId,     // 👈 ID duy nhất
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl'      => $ipnUrl,
            'lang'        => 'vi',
            'extraData'   => $extraData,   // 👈 mang id gốc
            'requestType' => $requestType,
            'signature'   => $signature
        ];

        $result = $this->execPostRequest($endpoint, json_encode($payload));
        Log::info('MoMo create result: ' . $result);

        $json = @json_decode($result, true);
        if (!is_array($json)) {
            return back()->with('error', 'MoMo không phản hồi hợp lệ.');
        }
        if (empty($json['payUrl'])) {
            Log::error('MoMo no payUrl', $json);
            return back()->with('error', 'MoMo lỗi: ' . ($json['message'] ?? 'Không tạo được liên kết thanh toán.'));
        }

        return redirect()->to($json['payUrl']);
    }


    private function processVnPayPayment($dataRequest)
    {
        Log::info('vnpay');

        // if (!isset($dataRequest['order_total_price'])) {
        //     return response()->json(['message' => 'Dữ liệu không hợp lệ'], Response::HTTP_BAD_REQUEST);
        // }

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = env('APP_URL') . '/thankyoupayment';
        $vnp_TmnCode = 'CW3MWMKN';
        $vnp_HashSecret = "2EQ9DCNFBR3H0GRQ4RCVHYTO1VZYXFLZ";
        $vnp_Locale = 'vn';
        // $vnp_BankCode = 'NCB';
        $vnp_TxnRef = $dataRequest['order_id'];
        $vnp_Amount = $dataRequest['order_total_price'] * 100;
        $vnp_IpAddr = request()->ip();
        $vnp_OrderInfo = "Thanh toán Vnpay";
        $vnp_OrderType = "Thanh toán hóa đơn";


        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);

        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        // Redis::setex("order:$vnp_TxnRef", 900, json_encode([
        //     'order_id' => $vnp_TxnRef,
        //     'data' => $dataRequest,
        // ]));
        Log::info($vnp_Url);
        return redirect()->to($vnp_Url);
    }

    public function storeCheckout(CheckOutRequest $request)
    {
        try {


            $order = null;
            $data_payment = $request->all();
            DB::transaction(function () use ($request, &$order) {
                $user = Auth::user();
                $data = $request->all();
                $data['user_id'] = $user->id;
                $data['slug'] = Order::generateCustomRandomString();
                $order = Order::query()->create($data);


                $cart = Cart::query()->where('user_id', $user->id)->first();
                $cartItem = CartItem::query()->where('cart_id', $cart->id)->where('is_check',)->get();
                $productVariants = [];
                foreach ($cartItem as $item) {
                    $productVariant = ProductVariant::with(
                        'capacity',
                        'color',
                        'product',
                        'cartitem'
                    )->find($item->product_variant_id);
                    $productVariant->cart_id = $item->cart_id;
                    $productVariants[] = $productVariant;
                }

                foreach ($productVariants as $item) {
                    foreach ($item->cartitem as $value) {
                        if ($value->cart_id == $item->cart_id) {
                            $quantityCart = $value->quantity;
                            $dataItem = [
                                'order_id' => $order->id,
                                'product_variant_id' => $item->id,
                                'quantity' => $value->quantity,
                                'name' => $item->product->name,
                                'sku' => $item->product->sku,
                                'img_thumbnail' => $item->product->img_thumbnail,
                                'price_regular' => $item->product->price_regular,
                                'price_sale' => $item->product->price_sale,
                                'variant_capacity_name' => $item->capacity->name,
                                'variant_color_name' => $item->color->name,

                            ];
                        }
                    }
                    OrderItem::query()->create($dataItem);
                    $data = [
                        'quantity' => $item->quantity - $quantityCart
                    ];
                    ProductVariant::query()->where('id', $item->id)->update($data);
                }
                CartItem::query()->where('cart_id', $cart->id)->delete();
                $cart->delete();
            });

            $data_payment['order_id'] = $order ? $order->id : 0;
            Log::info($data_payment);
            if ($request->method_payment != METHOD_PAYMENT_DELIVERY) {
                return $request->method_payment == METHOD_PAYMENT_MOMO
                    ?  $this->processPayment($data_payment)
                    :  $this->processVnPayPayment($data_payment);
            }
            return redirect()->route('thankyou', $order);
        } catch (\Throwable $th) {
            Log::debug(__CLASS__ . '@' . __FUNCTION__, [$th->getMessage()]);
            return back();
        }
    }



    public function thankyoupayment(Request $request)
    {
        try {
            $resultCode = $request->query('resultCode', '');
            $vnp_TransactionStatus = $request->query('vnp_TransactionStatus', '');
            $vnp_TxnRef = $request->query('vnp_TxnRef', '');
            $orderId = $request->query('orderId', '');
            $extraData = $request->query('extraData');

            if (!$vnp_TxnRef && $extraData) {
                $decoded = json_decode(base64_decode($extraData), true);
                $orderId = $decoded['order_id'] ?? null;
            }
            $txnRef = $orderId ?: $vnp_TxnRef;

            if (!$txnRef) {
                return back()->with('error', 'Vui lòng kiểm tra lại !!!');
            }

            $isSuccess = ($resultCode === "0" || $vnp_TransactionStatus === "00");

            if ($isSuccess) {
                Order::query()->find($txnRef)->update([
                    'status_payment' => STATUS_PAYMENT_PAID
                ]);
                return view('client.thankyoupayment');
            }
            return view('client.thankyoupayment');
        } catch (\Throwable $th) {
            return back()->with('error', 'Thanh toán không thành công !!!');
        }
    }


































    // public function paymentVnpay(Request $request)
    // {
    //     // dd($request);
    //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    //     $vnp_Returnurl = "https://duanshop.test/$request->order_id/thankyoupayment";
    //     $vnp_TmnCode = "CW3MWMKN"; //Mã website tại VNPAY 
    //     $vnp_HashSecret = "2EQ9DCNFBR3H0GRQ4RCVHYTO1VZYXFLZ"; //Chuỗi bí mật

    //     $vnp_TxnRef = $request->order_sku; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này  sang VNPAY
    //     $vnp_OrderInfo = "Thanh toán Vnpay";
    //     $vnp_OrderType = "Thanh toán hóa đơn";
    //     $vnp_Amount = $request->order_total_price * 100;
    //     $vnp_Locale = 'vn';
    //     $vnp_BankCode = 'NCB';
    //     $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //     //Add Params of 2.0.1 Version
    //     // $vnp_ExpireDate = $_POST['txtexpire'];
    //     //Billing
    //     // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
    //     // $vnp_Bill_Email = $_POST['txt_billing_email'];
    //     // $fullName = trim($_POST['txt_billing_fullname']);
    //     // if (isset($fullName) && trim($fullName) != '') {
    //     //     $name = explode(' ', $fullName);
    //     //     $vnp_Bill_FirstName = array_shift($name);
    //     //     $vnp_Bill_LastName = array_pop($name);
    //     // }
    //     // $vnp_Bill_Address = $_POST['txt_inv_addr1'];
    //     // $vnp_Bill_City = $_POST['txt_bill_city'];
    //     // $vnp_Bill_Country = $_POST['txt_bill_country'];
    //     // $vnp_Bill_State = $_POST['txt_bill_state'];
    //     // // Invoice
    //     // $vnp_Inv_Phone = $_POST['txt_inv_mobile'];
    //     // $vnp_Inv_Email = $_POST['txt_inv_email'];
    //     // $vnp_Inv_Customer = $_POST['txt_inv_customer'];
    //     // $vnp_Inv_Address = $_POST['txt_inv_addr1'];
    //     // $vnp_Inv_Company = $_POST['txt_inv_company'];
    //     // $vnp_Inv_Taxcode = $_POST['txt_inv_taxcode'];
    //     // $vnp_Inv_Type = $_POST['cbo_inv_type'];
    //     $inputData = array(
    //         "vnp_Version" => "2.1.0",
    //         "vnp_TmnCode" => $vnp_TmnCode,
    //         "vnp_Amount" => $vnp_Amount,
    //         "vnp_Command" => "pay",
    //         "vnp_CreateDate" => date('YmdHis'),
    //         "vnp_CurrCode" => "VND",
    //         "vnp_IpAddr" => $vnp_IpAddr,
    //         "vnp_Locale" => $vnp_Locale,
    //         "vnp_OrderInfo" => $vnp_OrderInfo,
    //         "vnp_OrderType" => $vnp_OrderType,
    //         "vnp_ReturnUrl" => $vnp_Returnurl,
    //         "vnp_TxnRef" => $vnp_TxnRef
    //         // "vnp_ExpireDate" => $vnp_ExpireDate,
    //         // "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
    //         // "vnp_Bill_Email" => $vnp_Bill_Email,
    //         // "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
    //         // "vnp_Bill_LastName" => $vnp_Bill_LastName,
    //         // "vnp_Bill_Address" => $vnp_Bill_Address,
    //         // "vnp_Bill_City" => $vnp_Bill_City,
    //         // "vnp_Bill_Country" => $vnp_Bill_Country,
    //         // "vnp_Inv_Phone" => $vnp_Inv_Phone,
    //         // "vnp_Inv_Email" => $vnp_Inv_Email,
    //         // "vnp_Inv_Customer" => $vnp_Inv_Customer,
    //         // "vnp_Inv_Address" => $vnp_Inv_Address,
    //         // "vnp_Inv_Company" => $vnp_Inv_Company,
    //         // "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
    //         // "vnp_Inv_Type" => $vnp_Inv_Type
    //     );

    //     if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    //         $inputData['vnp_BankCode'] = $vnp_BankCode;
    //     }
    //     // if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
    //     //     $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    //     // }

    //     //var_dump($inputData);
    //     ksort($inputData);
    //     $query = "";
    //     $i = 0;
    //     $hashdata = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    //         } else {
    //             $hashdata .= urlencode($key) . "=" . urlencode($value);
    //             $i = 1;
    //         }
    //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
    //     }

    //     $vnp_Url = $vnp_Url . "?" . $query;
    //     if (isset($vnp_HashSecret)) {
    //         $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
    //         $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    //     }
    //     $returnData = array(
    //         'code' => '00',
    //         'message' => 'success',
    //         'data' => $vnp_Url
    //     );
    //     if (isset($_POST['redirect'])) {
    //         header('Location: ' . $vnp_Url);
    //         die();
    //     } else {
    //         echo json_encode($returnData);
    //     }
    // }

}
