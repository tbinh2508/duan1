@extends('client.layouts.master')
@section('document')
    Shop
@endsection
@section('content')


    <div class="untree_co-section before-footer-section">
        <div class="container">

            {{-- @dd(($productVariants)) --}}
            @if (!empty($productVariants))
                <div class="row mb-5">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <div class="site-blocks-table">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:40px;">
                                        <input type="checkbox" id="checkAll" checked>
                                    </th>
                                    <th class="product-thumbnail">Ảnh</th>
                                    <th class="product-name">Sản phẩm</th>
                                    <th class="product-price">Giá</th>
                                    <th class="product-price">Size</th>
                                    <th class="product-price">Màu</th>
                                    <th class="product-quantity">Số lượng</th>
                                    <th class="product-total">Tổng</th>
                                    <th class="product-remove">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productVariants as $item)
                                    @php
                                        $currentCartItem = $item->cartitem->firstWhere('cart_id', $item->cart_id);
                                    @endphp
                                    <tr>
                                        <td>
                                            {{-- @if ($currentCartItem)
                                                <input type="checkbox" class="row-check" name="selected_cart_item_ids[]"
                                                    value="{{ $currentCartItem->id }}" checked>
                                            @endif --}}

                                           
                                            @if ($currentCartItem)
                                                <input type="checkbox" class="row-check" name="selected_cart_item_ids[]"
                                                    value="{{ $currentCartItem->id }}"
data-update-url="{{ route('cart.update_cart_item', $currentCartItem->id) }}"
                                                    @if ($currentCartItem->is_check) checked @endif>
                                            @endif

                                        </td>
                                        <td class="product-thumbnail">
                                            @if ($item->product->img_thumbnail)
                                                <img src="{{ Storage::url($item->product->img_thumbnail) }}" width="80px"
                                                    height="80px" alt="Image" class="img-fluid">
                                            @endif
                                        </td>
                                        <td class="product-name">
                                            <h2 class="h5 text-black">{{ $item->product->name }}</h2>
                                        </td>
                                        @if ($item->product->price_sale)
                                            <td style="width: 140px">{{ number_format($item->product->price_sale) }} đ
                                            </td>
                                        @else
                                            <td style="width: 140px">{{ number_format($item->product->price_regular) }}
                                                đ
                                            </td>
                                        @endif

                                        <td>
                                            <p>{{ $item->capacity->name }}</p>
                                        </td>
                                        <td>
                                            <p>{{ $item->color->name }}</p>
                                        </td>
                                        <td>



                                            <div class="input-group mb-3 d-flex align-items-center quantity-container"
                                                style="max-width: 120px;">


                                                <input disabled min="1" max="{{ $item->quantity }}"
                                                    name="quantity_{{ $item->id }}" type="text"
                                                    class="form-control p-2 text-center"
                                                    @foreach ($item->cartitem as $value)
                                                        @if ($value->cart_id == $item->cart_id)
                                                            value="{{ $value->quantity }}" 
                                                        @endif @endforeach>


                                            </div>
                                        </td>

                                        {{-- @if (!empty($item->product->price_sale))
@foreach ($item->cartitem as $value)
                                                @if ($value->cart_id == $item->cart_id)
                                                    <td style="width: 140px">
                                                        {{ number_format($item->product->price_sale * $value->quantity) }}
                                                        đ
                                                    </td>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($item->cartitem as $value)
                                                @if ($value->cart_id == $item->cart_id)
                                                    <td style="width: 140px">
                                                        {{ number_format($item->product->price_regular * $value->quantity) }}
                                                        đ
                                                    </td>
                                                @endif
                                            @endforeach
                                        @endif --}}

                                        @php
                                            $currentCartItem = $item->cartitem->firstWhere('cart_id', $item->cart_id);
                                            $qty = $currentCartItem?->quantity ?? 0;
                                            $unitPrice = $item->product->price_sale ?: $item->product->price_regular;
                                            $rowTotal = (int) $unitPrice * (int) $qty;
                                        @endphp

                                        <td style="width: 140px">
                                            <span class="row-total"
                                                data-total="{{ $rowTotal }}">{{ number_format($rowTotal) }} đ</span>
                                        </td>
                                        <td>
                                            @foreach ($item->cartitem as $value)
                                                @if ($value->cart_id == $item->cart_id)
                                                    <form action="{{ route('cart.delete', $value) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Bạn có chắc chắn xóa không !!!')"
                                                            type="submit" class="btn btn-black btn-sm">X</button>
                                                    </form>
                                                @endif
                                            @endforeach
</td>
                                    </tr>
                                    <form id="myForm" action="{{ route('cart.delete.all', $item->cart_id) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-5">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <button onclick="return confirm('Bạn có chắc chắn xóa tất cả không !!!')" type="submit"
                                    id="submitButton" class="btn btn-success btn-block">Xóa giỏ hàng</button></a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('shop') }}"><button class="btn btn-success btn-block">Continue
                                        Shopping</button></a>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">
                                <label class="text-black h4" for="coupon">Coupon</label>
                                <p>Enter your coupon code if you have one.</p>
                            </div>
                            <form action="{{ route('coupons.cart') }}" method="post" class="d-flex gap-2">
                                @csrf
                                <div class="col-md-8 mb-3 mb-md-0">
                                    <input type="text" class="form-control h-100" name="coupon_code" id="coupon"
                                        placeholder="Coupon Code">
                                </div>
                                <div class="col-md-4 ">
                                    <button class="btn btn-success p-2">Apply Coupon</button>
                                </div>
                            </form>
                        </div> --}}
                    </div>
                    <div class="col-md-6 pl-5">

                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <div class="row mb-4">
                                    <div class="col-md-12 text-right border-bottom">
                                        <h3 class="text-black h4 text-uppercase">Tổng đơn hàng</h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
<span class="text-black">Subtotal</span>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <strong class="text-black"><span
                                                id="subtotalAmount">{{ number_format($totals) }}</span> đ</strong>
                                    </div>
                                </div>

                                <div class="row mb-4 border-top pt-3">
                                    <div class="col-md-6">
                                        <span class="text-black">Total</span>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <strong class="text-black"><span
                                                id="totalAmount">{{ number_format($totals) }}</span> đ</strong>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('checkout') }}" class="btn btn-success py-3 w-100">Thanh toán</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            @else
                <div class="text-center">
                    <img src="{{ '/client/images/Cart-empty-v2.webp' }}" width="300px" alt="">
                    <p class="mt-3">Giỏ hàng của bạn đang trống.</p>
                    <p> Hãy chọn thêm sản phẩm để mua sắm nhé</p>

                    <a href="{{ route('shop') }}"><button class="btn btn-success">Continue
                            Shopping</button></a>

                </div>
            @endif

        </div>
    </div>

@endsection
{{-- @section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(function() {
            const $checkAll = $('#checkAll');
            const $subtotal = $('#subtotalAmount');
            const $total = $('#totalAmount');

            function $rowChecks() {
                return $('.row-check');
            }

            function formatVND(num) {
                try {
                    return new Intl.NumberFormat('vi-VN').format(num);
                } catch (e) {
                    return (num + '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            }

            function recalcTotals() {
                let sum = 0;
                $('.row-check:checked').each(function() {
                    const $row = $(this).closest('tr');
                    const val = parseInt($row.find('.row-total').data('total')) || 0;
                    sum += val;
                });
$subtotal.text(formatVND(sum));
                $total.text(formatVND(sum)); // nếu sau này có phí ship/giảm giá thì cộng/trừ ở đây
            }

            function syncHeader() {
                const $rows = $rowChecks();
                const allChecked = $rows.length > 0 && $rows.filter(':checked').length === $rows.length;
                $checkAll.prop('checked', allChecked);
            }

            // Toggle tất cả
            $checkAll.on('change', function() {
                $rowChecks().prop('checked', $(this).is(':checked'));
                recalcTotals();
            });

            // Tick từng dòng
            $(document).on('change', '.row-check', function() {
                syncHeader();
                recalcTotals();
            });

            // Khởi tạo
            $rowChecks().prop('checked', true);
            $checkAll.prop('checked', true);
            syncHeader();
            recalcTotals();
        });
    </script>
@endsection --}}

@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(function() {
            // CSRF cho AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const $checkAll = $('#checkAll');
            const $subtotal = $('#subtotalAmount');
            const $total = $('#totalAmount');

            function $rowChecks() {
                return $('.row-check');
            }

            function formatVND(num) {
                try {
                    return new Intl.NumberFormat('vi-VN').format(num);
                } catch (e) {
                    return (num + '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            }

            function recalcTotals() {
                let sum = 0;
                $('.row-check:checked').each(function() {
                    const $row = $(this).closest('tr');
                    const val = parseInt($row.find('.row-total').data('total')) || 0;
                    sum += val;
                });
                $subtotal.text(formatVND(sum));
                $total.text(formatVND(sum));
            }

            function syncHeader() {
                const $rows = $rowChecks();
                const allChecked = $rows.length > 0 && $rows.filter(':checked').length === $rows.length;
                $checkAll.prop('checked', allChecked);
            }

            // Gọi API cập nhật 1 item
            function updateCartItem($checkbox) {
                const url = $checkbox.data('update-url');
                const is_check = $checkbox.is(':checked') ? 1 : 0;
                if (!url) return;

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        is_check: is_check
                    },
}).fail(function(xhr) {
                    // Nếu lỗi, revert checkbox về trạng thái trước
                    $checkbox.prop('checked', !is_check);
                    syncHeader();
                    recalcTotals();
                    console.error('Update cart item failed:', xhr.responseText || xhr.statusText);
                });
            }

            // Toggle tất cả
            $checkAll.on('change', function() {
                const checked = $(this).is(':checked');
                $rowChecks().each(function() {
                    const $cb = $(this);
                    const prev = $cb.is(':checked');
                    $cb.prop('checked', checked);
                    if (prev !== checked) {
                        updateCartItem($cb); // chỉ gọi API khi trạng thái thực sự thay đổi
                    }
                });
                recalcTotals();
            });

            // Tick từng dòng
            $(document).on('change', '.row-check', function() {
                updateCartItem($(this));
                syncHeader();
                recalcTotals();
            });

            // Khởi tạo
            // $rowChecks().prop('checked', true);
            // $checkAll.prop('checked', true);
            syncHeader();
            recalcTotals();
        });
    </script>
@endsection

