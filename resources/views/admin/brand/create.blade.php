@extends('admin.layout.master')

@section('title')
    Thêm mới thương hiệu
@endsection

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="bg-light rounded min vh-100 p-4">
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Tên Thương hiệu</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-save me-2"></i> Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection