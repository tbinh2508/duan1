@extends('admin.layouts.master')
@section('title')
    Thêm mới sản phẩm
@endsection
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span style="font-size: 25px" class="m-0 font-weight-bold text-primary">Thêm mới sản phẩm</span>
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
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Thêm mới sản phẩm</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">


                                        <div class="form-group">
                                            <label for="name">Danh mục <span style="color: red">*</span></label>
                                            <select class="form-control" name="category_id" id="">
                                                <option selected value="">---Chọn Danh Mục---</option>

                                                @foreach ($categories as $key => $name)
                                                    <option value="{{ $key }}">{{ $name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="name">Tên <span style="color: red">*</span></label>
                                            <input type="text" value="{{ old('name') }}" name="name" id="name"
                                                class="form-control">
                                        </div>
                                        <div class="mt-3">
                                            <label for="sku" class="form-label">SKU <span
                                                    style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="sku" id="sku"
                                                value="{{ strtoupper(\Str::random(8)) }}">
                                        </div>
                                        <div class="mt-3">
                                            <label for="slug" class="form-label">Slug<span
                                                    style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="slug" id="slug"
                                                value="" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="img_thumbnail">Ảnh </label>
                                            <input type="file" name="img_thumbnail" id="img_thumbnail"
                                                class="form-control p-1">
                                        </div>
                                        <div class="form-group">
                                            <label for="price_regular">Giá gốc <span style="color: red">*</span></label>
                                            <input type="number" value="{{ old('price_regular') ?? 0 }}"
                                                name="price_regular" id="price_regular" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="price_sale">Giá Sale</label>
                                            <input type="number" value="{{ old('price_sale') ?? 0 }}" name="price_sale"
                                                id="price_sale" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block mb-2">Trạng thái hiển thị:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="featured"
                                                    name="featured" value="1">
                                                <label class="form-check-label" for="featured">Nổi bật</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="is_hot"
                                                    name="is_hot" value="1">
                                                <label class="form-check-label" for="is_hot">Hot</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="is_active"
                                                    name="is_active" value="1">
                                                <label class="form-check-label" for="is_active">Hoạt động</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Mô tả</label>
                                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
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
                                                                        <input type="number" class="form-control"
                                                                            value="0"
                                                                            name="product_variants[{{ $gbID . '-' . $colorID }}][quantity]">
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
                        {{-- End Biến thể --}}



                        {{-- Gallery --}}
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Ảnh</h4>
                                        <p class="btn btn-primary" id="add_gallery">Thêm ảnh</p>
                                    </div><!-- end card header -->
                                    <div id="body-gallery" class="card-body">

                                        <div class="mb-3 row">
                                            <label for="image_gallery" class="col-4 col-form-label"
                                                style="padding-left: 25px;">Ảnh</label>
                                            <div class="col-8">
                                                <input type="file" class="form-control p-1" name="image_galleries[]"
                                                    id="image_gallery" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        {{-- End Gallery --}}
                        <button type="submit" class="btn btn-primary w-100 my-5">Thêm mới</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script>
        function toSlug(str) {
            return (
                str
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9 -]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
            );
        }

        $(document).ready(function() {
            $('#name').on('input', function() {
                let name = $(this).val();
                $('#slug').val(toSlug(name));
            });
        });
    </script>
@endsection
