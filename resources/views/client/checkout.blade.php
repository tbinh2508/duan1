@extends('client.layouts.master')
@section('document')
    ShopSieuReOk
@endsection
@section('content')

    <div class="untree_co-section">
        <form action="{{ route('store.checkout') }}" method="post">
            @csrf

            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black">Thông tin giao hàng</h2>
                        <div class="p-3 p-lg-5 border bg-white">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $item)
                                            <li>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="order_user_name" class="text-black"> Tên </label><span class="text-danger">
                                        *</span>
                                    <input value="{{ old('order_user_name') ?? Auth::user()->name }}" placeholder="Name"
                                        type="text" class="form-control" id="order_user_name" name="order_user_name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="order_user_address" class="text-black">Địa chỉ <span
                                            class="text-danger">*</span></label>
                                    <input value="{{ old('order_user_address') ?? Auth::user()->address }}" type="text"
                                        class="form-control" id="order_user_address" name="order_user_address"
                                        placeholder="địa chỉ">
                                </div>
                            </div>




                            <div class="form-group row mb-5">
                                <div class="col-md-6">
                                    <label for="order_user_email" class="text-black">Email <span
                                            class="text-danger">*</span></label>
                                    <input value="{{ old('order_user_email') ?? Auth::user()->email }}" type="email"
                                        placeholder="Email" class="form-control" id="order_user_email"
                                        name="order_user_email">
                                </div>
                                <div class="col-md-6">
                                    <label for="order_user_phone" class="text-black">SĐT <span
                                            class="text-danger">*</span></label>
                                    <input value="{{ old('order_user_phone') ?? Auth::user()->phone }}" type="number"
                                        class="form-control" id="order_user_phone" name="order_user_phone"
                                        placeholder="Số điện thoại">
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="order_user_note" class="text-black">Ghi chú</label>
                                <textarea name="order_user_note" id="order_user_note" cols="30" rows="5" class="form-control"
                                    placeholder="Nhập ghi chú ...">{{ old('order_user_note') }}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h2 class="h3 mb-3 text-black">Thông tin đơn hàng</h2>
                                <div class="p-3 p-lg-5 border bg-white">
                                    <table class="table table-striped table-bordered mb-5 text-center">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Tổng</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productVariants as $item)
                                                <tr>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>
                                                        @foreach ($item->cartitem as $value)
                                                            @if ($value->cart_id == $item->cart_id)
                                                                {{ $value->quantity }}
                                                            @endif
                                                        @endforeach
                                                    </td>

                                                    <!-- Cột Total: Tính tổng giá trị sản phẩm -->
                                                    @foreach ($item->cartitem as $value)
                                                        @if ($value->cart_id == $item->cart_id)
                                                            <td>{{ number_format($value->quantity * $item->product->price_sale) }}
                                                                đ</td>
                                                        @endif
                                                    @endforeach




                                                </tr>
                                            @endforeach


                                            <tr class="table-info">
                                                <td colspan="2" class="text-black font-weight-bold"><strong>Order
                                                        Subtotal</strong></td>
                                                <td class="text-black">{{ number_format($totals) }} đ</td>
                                            </tr>
                                            <input type="hidden" name="order_total_price" value="{{ $totals }}">

                                            <tr class="table-success text-dark">
                                                <td colspan="2" class="text-black font-weight-bold">
                                                    <strong>Tổng:</strong></td>
                                                <td class="text-black font-weight-bold">
                                                    <strong>{{ number_format($totals) }} đ</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>




                                    <div class="mt-5">
                                        <h4 class="text-black fw-bold mb-3">Phương thức thanh toán</h4>
                                        <div class="list-group">
                                            <!-- Phương thức thanh toán khi nhận hàng -->
                                            <label class="list-group-item d-flex align-items-center gap-3">
                                                <input class="form-check-input flex-shrink-0" type="radio"
                                                    name="method_payment" value="cash_delivery" id="cash_delivery" checked>
                                                <div>
                                                    <span
                                                        class="fw-semibold">{{ methodPayment(METHOD_PAYMENT_DELIVERY) }}</span>
                                                    <p class="mb-0 text-muted small">Thanh toán khi nhận hàng</p>
                                                </div>
                                            </label>

                                            <!-- Phương thức thanh toán qua VNPay -->
                                            <label class="list-group-item d-flex align-items-center gap-3 mt-2">
                                                <input class="form-check-input flex-shrink-0" type="radio"
                                                    name="method_payment" value="vnpay_payment" id="vnpay_payment">
                                                <div>
                                                    <span
                                                        class="fw-semibold">{{ methodPayment(METHOD_PAYMENT_VNPAY) }}</span>
                                                    <p class="mb-0 text-muted small">Thanh toán qua VNPay an toàn và nhanh
                                                        chóng</p>
                                                </div>
                                            </label>

                                            <label class="list-group-item d-flex align-items-center gap-3 mt-2">
                                                <input class="form-check-input flex-shrink-0" type="radio"
                                                    name="method_payment" value="momo_payment" id="momo_payment">
                                                <div>
                                                    <span
                                                        class="fw-semibold">{{ methodPayment(METHOD_PAYMENT_MOMO) }}</span>
                                                    <p class="mb-0 text-muted small">Thanh toán qua MOMO an toàn và nhanh
                                                        chóng</p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>


                                    <input type="hidden" class="form-control" name="sku"
                                        value="{{ strtoupper(\Str::random(10)) }}">

                                    <div class="form-group mt-4">
                                        <button class="btn btn-success py-3 w-100 btn-block">Thanh toán</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- </form> -->
            </div>
        </form>
    </div>

@endsection
