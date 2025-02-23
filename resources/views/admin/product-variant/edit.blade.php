@extends('admin.layout.master')

@section('title')
    Cập nhật biến thể - {{ $product->name }}
@endsection

@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Cập nhật biến thể - {{ $product->name }}</h6>
        <div id="variant-form">
            <form id="form-variant" action="{{ route('product-variant.update', $variant->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                        <div>
                            <label for="" class="form-label">Giá</label>
                            <input type="number" min="0" step="0.1" class="form-control" name="price" value="{{ $variant->price }}">
                            <span class="text-danger error-price"></span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Số lượng</label>
                            <input min="1" step="1" type="number" class="form-control" name="quantity" value="{{ $variant->quantity }}">
                            <span class="text-danger error-quantity"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <label for="" class="form-label">Kích cỡ</label>
                            <input min="35" max="50" step="1" type="number" class="form-control" name="size" value="{{ $variant->size }}">
                            <span class="text-danger error-size"></span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Màu sắc</label>
                            <div>
                                <input type="color" class="form-control-color" name="color" value="{{ $variant->color }}">  
                            </div>
                            <span class="text-danger error-color"></span>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save me-2"></i>Lưu</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#form-variant").on("submit", function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status === "success") {
                            let alertSuccess = `
                                <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `;
                            $("#variant-form").prepend(alertSuccess);

                            $("input[name='name']").val("");

                            setTimeout(() => {
                                $("#alert-success").fadeOut();
                                window.location.href = "{{ route('product-variant.index',  $product->id) }}";
                            }, 3000);;
                        }
                    }, error: function (xhr) {
                        console.error(xhr.responseText);

                        $(".error-name").text("");
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.quantity) {
                                $(".error-quantity").text(errors.quantity[0]);
                            }
                            if (errors.price) {
                                $(".error-price").text(errors.price[0]);
                            }
                            if (errors.size) {
                                $(".error-size").text(errors.size[0]);
                            }
                            if (errors.color) {
                                $(".error-color").text(errors.color[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection