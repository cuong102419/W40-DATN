@extends('admin.layout.master')

@section('title')
    Thêm mới thương hiệu
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div id="form-brand" class="bg-light rounded min vh-100 p-4">
                <form action="{{ route('admin-brand.store') }}" id="brand-form" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên Thương hiệu</label>
                        <input type="text" name="name" class="form-control mb-2">
                        <span class="text-danger error-name"></span>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('admin-brand.index') }}" class="btn btn-sm btn-secondary"><i
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
                            let alertSuccess = `
                            <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                            $("#form-brand").prepend(alertSuccess);

                            $("input[name='name']").val("");

                            setTimeout(() => {
                                $("#alert-success").fadeOut();
                            }, 3000);;
                        }
                    }, error: function (xhr) {
                        console.error(xhr.responseText);

                        $(".error-name").text("");
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $(".error-name").text(errors.name[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection