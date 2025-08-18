@extends('client.layouts.master')
@section('document')
    ShopSieuReOk
@endsection
@section('content')
<div class="untree_co-section before-footer-section">
        <div class="container">
            {{-- @dd($listOrders->toArray()) --}}
            @if (!empty($listOrders))
                <div class="row mb-5">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session()->get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive shadow-sm rounded">
                        <table class="table table-hover align-middle text-center custom-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Trạng thái thanh toán</th>
                                    <th>Tổng</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listOrders as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            <span
                                                class="badge bg-primary rounded-pill 
                                                @if ($item->status_order == STATUS_ORDER_PENDING) bg-warning 
                                                @elseif ($item->status_order == STATUS_ORDER_DELIVERED) bg-success 
                                                @elseif ($item->status_order == STATUS_ORDER_CANCELED) bg-danger @endif">
                                                {{ statusOrders($item->status_order) }}
                                            </span>
                                        </td>
                                        <td>{{ methodPayment($item->method_payment) }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill 
                                                @if ($item->status_payment == STATUS_PAYMENT_PAID) bg-success 
                                                @else bg-secondary @endif">
                                                {{ statusPayment($item->status_payment) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($item->order_total_price) }} đ</td>
                                        <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('show.orders', $item) }}" class="btn btn-success btn-sm">
                                                <i class="bi bi-eye"></i> Show
                                            </a>
                                            <form action="{{ route('orders.cancel', $item) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status_order"
                                                    value="{{ $item->status_order }}">
                                                <button
                                                    onclick="return confirm('Bạn có chắc chắn hủy đơn hàng này không !!!')"
                                                    class="btn btn-danger btn-sm" type="submit"
                                                    @disabled($item->status_order !== STATUS_ORDER_PENDING || $item->status_payment == STATUS_PAYMENT_PAID)>
                                                    <i class="bi bi-x-circle"></i> Cancel
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class=" mt-4">
                        {{ $listOrders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="text-center">
                    <img src="{{ '/client/images/Cart-empty-v2.webp' }}" width="300px" alt="Empty Cart" class="img-fluid">
                    <h5 class="mt-3 text-muted">Đơn hàng của bạn đang trống.</h5>
                    <p>Hãy chọn thêm sản phẩm để mua sắm nhé.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">
                        <i class="bi bi-cart-plus"></i> Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection