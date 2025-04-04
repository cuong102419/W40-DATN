@extends('admin.layout.master')

@section('title')
    Thêm mới khuyến mãi
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div id="form-voucher" class="bg-light rounded p-4">
                <form action="{{ route('admin-voucher.store') }}" id="voucher-form" method="post">
                    @csrf
                    <div>
                        <label class="form-label">Tên khuyến mãi</label>
                        <input type="text" name="name" class="form-control mb-2">
                        <span class="text-danger error-name"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Mã khuyến mãi</label>
                        <input type="text" name="code" class="form-control mb-2">
                        <span class="text-danger error-code"></span>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Kiểu giá trị</label>
                        <select name="type" class="form-select">
                            <option value="percentage">Giảm giá theo phần trăm</option>
                            <option value="fixed">Giảm giá theo số tiền</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Giá trị khuyến mãi</label>
                        <input type="number" step="0.1" min="0" max="100" name="value" class="form-control mb-2">
                        <span class="text-danger error-value"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Giá trị tối thiểu áp dụng</label>
                        <input type="number" step="0.1" min="0" max="100" name="value" class="form-control mb-2">
                        <span class="text-danger error-value"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Giảm giá tối đa</label>
                        <input type="number" step="0.1" min="0" max="100" name="value" class="form-control mb-2">
                        <span class="text-danger error-value"></span>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Loại khuyến mại</label>
                        <select name="kind" class="form-select">
                            <option value="shipping">Phí vận chuyển</option>
                            <option value="total">Giảm giá đơn hàng</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="quantity" class="form-control mb-2">
                        <span class="text-danger error-quantity"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="start_date" class="form-control mb-2">
                        <span class="text-danger error-expiration_date"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Ngày hết hạn</label>
                        <input type="date" name="expiration_date" class="form-control mb-2">
                        <span class="text-danger error-expiration_date"></span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin-voucher.index') }}" class="btn btn-sm btn-secondary"><i
                                class="fas fa-arrow-left"></i> Danh sách</a>
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save me-2"></i> Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#voucher-form").on("submit", function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            // Xóa dữ liệu sau khi thêm thành công
                            $("input[name='name']").val("");
                            $("input[name='code']").val("");
                            $("input[name='value']").val("");
                            $("input[name='quantity']").val("");
                            $("input[name='expiration_date']").val("");

                            toastr.success(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);

                        // Xóa thông báo lỗi cũ
                        $(".error-name, .error-code, .error-value, .error-quantity, .error-expiration_date").text("");

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) $(".error-name").text(errors.name[0]);
                            if (errors.code) $(".error-code").text(errors.code[0]);
                            if (errors.value) $(".error-value").text(errors.value[0]);
                            if (errors.quantity) $(".error-quantity").text(errors.quantity[0]);
                            if (errors.expiration_date) $(".error-expiration_date").text(errors.expiration_date[0]);
                        }
                    }
                });
            });
        });


    </script>
@endsection