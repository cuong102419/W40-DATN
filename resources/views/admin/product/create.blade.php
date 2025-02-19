@extends('admin.layout.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <div class="bg-light rounded h-100 p-4">
        <form action="" method="post">
            <div class="row g-4">
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="" name="" class="form-control">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Danh mục</label>
                        <select class="form-select" name="" id="">
                            <option value="">Chọn danh mục</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Thương hiệu</label>
                        <select class="form-select" name="" id="">
                            <option value="">Chọn thương hiệu</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Mô tả</label>
                    <div class="mb-3">
                        <textarea class="form-control" name="" id="description" cols="30" rows="5"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
