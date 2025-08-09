@extends('client.layouts.master')
@section('document')
    Trang chủ
@endsection
@section('content')
    <div class="testimonial-section">
        {{-- <div class="container"> --}}

        <div class="row justify-content-center">
            <div class="testimonial-slider-wrap text-center">

                <div id="testimonial-nav">
                    <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                    <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                </div>

                <div class="testimonial-slider">
                    <div class="testimonial-block text-center">
                        <blockquote class="">

                            <img src="{{ '/client/images/burnstore-banner-23-1-1.jpg' }}" width="100%" height="666px"
                                alt="">
                        </blockquote>
                    </div>
                    <div class="testimonial-block text-center">
                        <blockquote class="">

                            <img src="{{ '/client/images/banner-ninja-2.jpg' }}" width="100%" height="666px" alt="">
                        </blockquote>
                    </div>
                          <div class="testimonial-block text-center">
                        <blockquote class="">

                            <img src="{{ '/client/images/baner3.jpg' }}" width="100%" height="666px" alt="">
                        </blockquote>
                    </div>

                </div>

            </div>
        </div>
        {{-- </div> --}}
    </div>

    <!-- Start Product Section -->
    <div class="product-section">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col">
                    <h2 class="h4 mb-0">Danh sách sản phẩm</h2>
                    {{-- <p class="text-muted small mb-0">Dày đẹp – ngồi sướng – giá hợp lý.</p> --}}
                </div>
                <div class="col-auto">
                    <a href="{{route('shop')}}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
                </div>
            </div>
            <div class="row">

                <!-- Start Column 2 -->
                @foreach ($products as $item)
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item" href="{{ route('detail', $item) }}">
                            <img src="{{ Storage::url($item->img_thumbnail) }}" style="height: 280px" width="280px"
                                class="img-fluid product-thumbnail">
                            <h3 class="product-title">{{ $item->name }}</h3>
                            <strong class="product-price">{{ number_format($item->price_regular) }} VND</strong>

                            <span class="icon-cross">
                                <img src="/client/images/cross.svg" class="img-fluid">
                            </span>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- End Product Section -->



    <!-- Start Popular Product -->
    <section class="popular-product my-5">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col">
                    <h2 class="h4 mb-0">Sản phẩm nổi bật</h2>
                    {{-- <p class="text-muted small mb-0">Dày đẹp – ngồi sướng – giá hợp lý.</p> --}}
                </div>
                <div class="col-auto">
                    <a href="{{route('shop')}}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
                </div>
            </div>

            <div class="row g-4">
                <!-- ITEM -->
                @foreach ($product_featured as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        <a href="{{ route('detail', $product) }}" class="product-item-sm d-flex p-3 rounded-3 shadow-sm text-decoration-none h-100">
                            <div class="thumbnail flex-shrink-0 me-3">
                                <img src="{{ Storage::url($product->img_thumbnail) }}" alt=""
                                    class="img-fluid rounded-2">
                            </div>
                            <div class="pt-1 flex-grow-1">
                                <h3 class="h6 text-dark mb-1">{{ $product->name }}</h3>
                                <p class="text-muted small mb-2 text-truncate" style="max-width: 250px;">
                                    {{ $product->description }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="price fw-semibold">{{ $product->price_regular }}</span>
                                    <span class="link-primary small">Xem chi tiết</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- End Popular Product -->
@endsection
