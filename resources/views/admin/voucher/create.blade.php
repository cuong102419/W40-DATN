@extends('admin.layout.master')

@section('title')
    Thêm mới khuyến mãi
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div id="form-voucher" class="bg-light rounded min vh-100 p-4">
                <form action="{{ route('admin-voucher.store') }}" id="voucher-form" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên khuyến mãi</label>
                        <input type="text" name="name" class="form-control mb-2">
                        <span class="text-danger error-name"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã khuyến mãi</label>
                        <input type="text" name="code" class="form-control mb-2">
                        <span class="text-danger error-code"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá trị khuyến mãi</label>
                        <input type="text" name="value" class="form-control mb-2">
                        <span class="text-danger error-value"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="quantity" class="form-control mb-2">
                        <span class="text-danger error-quantity"></span>
                    </div>
                    <div class="mb-3">
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
    $("#brand-form").on("submit", function (e) {
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

                    toastr.success(response.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);

                // Xóa thông báo lỗi cũ
                $(".error-name, .error-code, .error-value, .error-quantity").text("");

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.name) $(".error-name").text(errors.name[0]);
                    if (errors.code) $(".error-code").text(errors.code[0]);
                    if (errors.value) $(".error-value").text(errors.value[0]);
                    if (errors.quantity) $(".error-quantity").text(errors.quantity[0]);
                }
            }
        });
    });
});


    </script>
@endsection