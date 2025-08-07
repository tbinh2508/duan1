@extends('admin.layouts.master')
@section('title')
    Product
@endsection
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span style="font-size: 25px" class="m-0 font-weight-bold text-primary">List Product</span>
                <a class="btn btn-primary" style="float: right" href="{{ route('products.create') }}" role="button">Thêm
                    mới</a>

            </div>
            <div class="card-body">
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
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Danh mục</th>
                                <th>Sku</th>
                                <th>Tên</th>
                                <th>Ảnh</th>
                                <th>Giá</th>
                                <th>Nổi bật</th>
                                <th>Thời gian</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td> {{ $item->sku }} </td>
                                    <td> {{ $item->name }} </td>
                                    <td>
                                        @if ($item->img_thumbnail)
                                            <img src="{{ Storage::url($item->img_thumbnail) }}" width="100px"
                                                height="100px" alt="">
                                        @endif
                                    </td>
                                    <td style="width: 130px;"> {{ number_format($item->price_regular) }} VND</td>
                                    <td>
                                        @if ($item->featured)
                                            <button disabled class="btn btn-success">Nổi bật</button>
                                        @else
                                            <button disabled class="btn btn-warning">Thường</button>
                                        @endif
                                    </td>
                                    <td> {{ $item->updated_at->format('d/m/Y H:i:s') }} </td>
                                    <td >
                                        <a class="btn btn-dark mr-2" href="{{ route('products.edit', $item) }}"
                                            role="button">Sửa</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
