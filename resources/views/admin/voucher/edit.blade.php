@extends('admin.layout.master')

@section('title')
    Cập nhật thương hiệu
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div id="form-voucher" class="bg-light rounded min vh-100 p-4">
                <form action="{{ route('admin-voucher.update', $voucher->id) }}" id="voucher-form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="text" name="name" disabled class="form-control mb-2" value="{{ $voucher->id }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên khuyến mãi</label>
                        <input type="text" name="name" class="form-control mb-2" value="{{ $voucher->name }}">
                        <span class="text-danger error-name"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mã khuyến mãi</label>
                        <input type="text" name="code" class="form-control mb-2" value="{{ $voucher->code }}">
                        <span class="text-danger error-code"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá trị khuyến mãi</label>
                        <input type="text" name="value" class="form-control mb-2" value="{{ $voucher->value }}">
                        <span class="text-danger error-value"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số Lượng</label>
                        <input type="text" name="quantity" class="form-control mb-2" value="{{ $voucher->quantity }}">
                        <span class="text-danger error-quantity"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày kết thúc</label>
                        <input type="text" name="expiration_date" class="form-control mb-2" value="{{ $voucher->expiration_date }}">
                        <span class="text-danger error-expiration_date"></span>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('admin-voucher.index') }}" class="btn btn-sm btn-secondary"><i
                                class="fas fa-arrow-left"></i> Danh sách</a>
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save me-2"></i>Cập nhật</button>
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
            let formData = form.serialize() + "&_method=PUT";

            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        toastr.success(response.message);

                        setTimeout(() => {
                            window.location.href = "{{ route('admin-voucher.index') }}";
                        }, 2000);
                    }
                }, 
                error: function (xhr) {
                    console.error(xhr.responseText);

                    $(".error-name").text("");
                    $(".error-code").text("");
                    $(".error-value").text("");
                    $(".error-quantity").text("");
                    $("input[name='expiration_date']").val("");

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $(".error-name").text(errors.name[0]);
                        }
                        if (errors.code) {
                            $(".error-code").text(errors.code[0]);
                        }
                        if (errors.value) {
                            $(".error-value").text(errors.value[0]);
                        }
                        if (errors.quantity) {
                            $(".error-quantity").text(errors.quantity[0]);
                        }
                        if (errors.expiration_date) {
                            $(".error-expiration_date").text(errors.expiration_date[0]);
                        }
                    }
                }
            });
        });
    });
    </script>
@endsection