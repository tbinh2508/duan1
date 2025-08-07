@extends('admin.layouts.master')
@section('title')
    Sửa danh mục
@endsection
@section('content')
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span style="font-size: 25px" class="m-0 font-weight-bold text-primary">Sủa danh mục</span>
                {{-- <a class="btn btn-primary" style="float: right" href="{{ route('Categorys.create') }}" role="button">Thêm mới</a> --}}

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
                    <form action="{{ route('categories.update', $data) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- @dd($data->category_id) --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Sửa danh mục</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">


                                        <div class="form-group">
                                            <label for="name">Tên</label>
                                            <input type="text" value="{{ $data->name }}" name="name"
                                                id="name" class="form-control">
                                        </div>


                                        <div class="form-group">
                                            <label for="slug">Slug</label>
                                            <input type="text" value="{{  $data->slug }}" name="slug" id="slug"
                                                class="form-control" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="is_active">Hoạt đông</label>
                                            <input type="checkbox" name="is_active" {{  $data->is_active ? 'checked' : "" }} value="1"  id="is_active">
                                        </div>
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