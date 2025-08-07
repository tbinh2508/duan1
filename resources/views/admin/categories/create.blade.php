@extends('admin.layouts.master')
@section('title')
    Tạo mới danh mục
@endsection
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span style="font-size: 25px" class="m-0 font-weight-bold text-primary">Tạo mới danh mục</span>

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
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Tạo mới danh mục</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">



                                        <div class="form-group">
                                            <label for="name">Tên</label>
                                            <input type="text" value="{{ old('name') }}" name="name" id="name"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" value="{{ old('slug') }}" name="slug" id="slug"
                                                class="form-control" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="is_active">Hoạt đông</label>
                                            <input type="checkbox" name="is_active" value="1" checked id="is_active">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--end col-->
                        </div>

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
            const randomString = Math.random().toString(36).substring(2, 15); // 4 ký tự ngẫu nhiên
            return (
                str
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9 -]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-') + '-' + randomString
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
