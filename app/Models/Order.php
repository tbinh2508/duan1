<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // const STATUS_ORDER = [
    //     'pending' => 'Chờ xác nhận',
    //     'confirmed' => 'Đã xác nhận',
    //     'preparing_goods' => 'Đang chuẩn bị hàng',
    //     'shipping' => 'Đang vận chuyển',
    //     'delivered' => 'Đã giao hàng',
    //     'canceled' => 'Đơn hàng đã bị hủy',
    // ];

    // const METHOD_PAYMENT = [
    //     'cash_delivery' => 'Thanh toán khi nhận hàng',
    //     'vnpay_payment' => 'Thanh toán VNPay'
    // ];

    // const STATUS_PAYMENT = [
    //     'unpaid' => 'Chưa thanh toán',
    //     'paid' => 'Đã thanh toán',
    // ];

    protected $fillable = [
        'user_id',
        'order_user_name',
        'order_user_email',
        'order_user_phone',
        'order_user_address',
        'order_user_note',
        'status_order',
        'method_payment',
        'status_payment',
        'order_total_price',
        'sku',
        'slug'
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateCustomRandomString()
    {
        $characters = 'abcdefghjklmnpqrstuvwxyz';
        $charLength = strlen($characters);

        $code = '';
        for ($i = 0; $i < 13; $i++) {
            $code .= $characters[rand(0, $charLength - 1)];
        }

        $formattedCode = substr($code, 0, 3) . '-' .
            substr($code, 3, 4) . '-' .
            substr($code, 7, 3) . '-' .
            substr($code, 10, 3);

        return $formattedCode;
    }
}
