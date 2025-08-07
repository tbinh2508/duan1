@extends('admin.layouts.master')
@section('title')
    Chỉnh sửa sản phẩm
@endsection
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span style="font-size: 25px" class="m-0 font-weight-bold text-primary">Chỉnh sửa sản phẩm</span>
                {{-- <a class="btn btn-primary" style="float: right" href="{{ route('products.create') }}" role="button">Thêm mới</a> --}}

            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <form action="{{ route('products.update', $data) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- @dd($data->category_id) --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Chỉnh sửa sản phẩm</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">


                                        <div class="form-group">
                                            <label for="name">Danh mục</label>
                                            <select class="form-control" name="category_id" id="">
                                                <option selected value="">---Chọn Danh Mục---</option>

                                                @foreach ($categories as $id => $name)
                                                    <option @selected($id === $data->category_id) value="{{ $id }}">
                                                        {{ $name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="name">Tên</label>
                                            <input type="text" value="{{ $data->name }}" name="name"
                                                id="name" class="form-control">
                                        </div>
                                        <div class="mt-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" class="form-control" name="sku" id="sku"
                                                value="{{ $data->sku }}">
                                        </div>
                                        <div class="mt-3">
                                            <label for="slug" class="form-label">Slug<span
                                                    style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="slug" id="slug"
                                                value="{{ $data->slug }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="img_thumbnail">Image</label>
                                            <input type="file" name="img_thumbnail" id="img_thumbnail"
                                                class="form-control p-1">
                                            @if ($data->img_thumbnail)
                                                <img src="{{ Storage::url($data->img_thumbnail) }}" class="my-2"
                                                    width="100px" alt="">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="price_regular">Price Regular</label>
                                            <input type="number" value="{{ $data->price_regular }}"
                                                name="price_regular" id="price_regular" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="price_sale">Price Sale</label>
                                            <input type="number" value="{{ $data->price_sale }}" name="price_sale"
                                                id="price_sale" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block mb-2">Trạng thái hiển thị:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" @checked($data->featured) id="featured"
                                                    name="featured" value="1">
                                                <label class="form-check-label"   for="featured">Nổi bật</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" @checked($data->is_hot) id="is_hot"
                                                    name="is_hot" value="1">
                                                <label class="form-check-label" for="is_hot">Hot</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" @checked($data->is_active) id="is_active"
                                                    name="is_active" value="1">
                                                <label class="form-check-label" for="is_active">Hoạt động</label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description">Mô tả</label>
                                            <textarea name="description" id="description" class="form-control">{{ $data->description }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--end col-->
                        </div>

                        {{-- Biến thể --}}

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Biến thể sản phẩm</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <div class="live-preview">
                                            <div class="row gy-4">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr class="text-center">
                                                            <th>Size</th>
                                                            <th>Màu</th>
                                                            <th>Số lượng</th>
                                                        </tr>

                                                        @foreach ($capacities as $gbID => $gbName)
                                                            @php($flagRowspan = true)

                                                            @foreach ($colors as $colorID => $colorName)
                                                                <tr class="text-center">

                                                                    @if ($flagRowspan)
                                                                        <td style="vertical-align: middle;"
                                                                            rowspan="{{ count($colors) }}">
                                                                            <b>{{ $gbName }}</b>
                                                                        </td>
                                                                    @endif

                                                                    @php($flagRowspan = false)

                                                                    <td style="width: 70px;">
                                                                        <div
                                                                            style="width: 50px ; height: 50px; background: {{ $colorName }};">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        @foreach ($data->product_variant as $item)
                                                                            @if ($item->color_id === $colorID && $item->capacity_id === $gbID)
                                                                                <input type="number" class="form-control"
                                                                                    value="{{ $item->quantity }}"
                                                                                    name="product_variants[{{ $gbID . '-' . $colorID }}][quantity]">
                                                                            @endif
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>

                        {{-- Gallery --}}
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Ảnh</h4>
                                        <p class="btn btn-primary" id="add_gallery_update">Thêm gallery</p>
                                    </div><!-- end card header -->
                                    <div id="body-gallery_update" class="card-body">

                                        @foreach ($data->galleries as $item)
                                            <div class="mb-3 d-flex align-items-center">
                                                @if ($item->image && Storage::exists($item->image))
                                                    <label for="image_gallery" class="col-4 col-form-label">
                                                        <img src="{{ Storage::url($item->image) }}" width="100px"
                                                            height="100px" alt=""></label>
                                                @endif

                                                <input type="file" name="image_galleries[{{ $item->id }}]"
                                                    class="form-control p-1 " id="image_gallery">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        {{-- End Gallery --}}
                        <button type="submit" class="btn btn-primary w-100 my-5">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
