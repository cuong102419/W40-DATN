@extends('admin.layout.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <div class="bg-light rounded h-100 p-4">
        <form action="{{ route('admin-product.store') }}" method="post">
            <div class="row g-4">
                <div class="col-6">
                    <div class="mb-3">
                        <label class="form-label">Mã sản phẩm</label>
                        <input type="text" name="sku" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Giảm giá</label>
                        <input type="number" name="discount" class="form-control" min="0" step="0.1">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Danh mục</label>
                        <select class="form-select" name="category" id="">
                            <option value="">Chọn danh mục</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Thương hiệu</label>
                        <select class="form-select" name="brand" id="">
                            <option value="">Chọn thương hiệu</option>
                        </select>
                    </div>
                    <div class="mb-3 mt-5 form-check">
                        <label class="form-check-label" for="">Sản phẩm nổi bật</label>
                        <input type="checkbox" name="feartured" value="1" class="form-check-input">
                    </div>
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Mô tả</label>
                    <div class="mb-3">
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit"><i class="fas fa-save me-2"></i> Lưu</button>
                </div>
            </div>
        </form>
    </div>
@endsection