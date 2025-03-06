@extends('auth.layout.master')

@section('title')
    Đăng nhập
@endsection

@section('content')
    <div id="form-signin" class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
        @if (session('success'))
            <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div id="alert-error" class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="{{ route('home') }}" class="pt-1">
                <img src="{{ asset('client/img/logo1.webp') }}" width="150" alt="">
            </a>
            <h4 class="pt-3 text-primary">Đăng nhập</h4>
        </div>
        <form id="signin-form" action="{{ route('signin.signin') }}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="floatingInput">
                <label for="floatingInput">Email</label>
                <div class="mt-2">
                    <span class="text-danger error-email"></span>
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control" id="floatingPassword">
                <label for="floatingPassword">Mật khẩu</label>
                <div class="mt-2">
                    <span class="text-danger error-password"></span>
                </div>
            </div>
            <div class="mb-4">
                <a href="">Quên mật khẩu</a>
            </div>
            <button type="submit" class="btn btn-primary py-3 w-100 mb-4 text-uppercase">Đăng nhập</button>
            <p class="text-center mb-0">Bạn chưa có tài khoản? <a href="{{ route('signup') }}">Đăng ký</a></p>
            <div class="d-flex justify-content-center align-items-center">
                <p class="text-center me-2 mt-3">Hoặc đăng nhập bằng </p>
                <a href="{{ route('auth.google') }}" class="btn btn-outline-primary "><i
                        class="fab fa-google fa-lg me-2"></i><strong>Google</strong></a>
            </div>
        </form>
    </div>
    {{-- Validate ajax --}}
    <script>
        $(document).ready(function () {
            $("#signin-form").on("submit", function (e) {
                e.preventDefault();

                $(".text-danger").text("");

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
                            $("#form-signin").prepend(alertSuccess);


                            setTimeout(() => {
                                $("#alert-success").fadeOut();
                                if (response.role === 'admin') {
                                    window.location.href = "{{ route('dashboard.index') }}";
                                } else {
                                    window.location.href = "{{ route('home') }}";
                                }
                            }, 3000);;
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $(".error-email").text(errors.email[0]);
                            }
                            if (errors.password) {
                                $(".error-password").text(errors.password[0]);
                            }
                        }

                        if (xhr.responseJSON && xhr.responseJSON.status === "error") {
                            let alertError = `
                                <div id="alert-error" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation me-2"></i>${xhr.responseJSON.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `;
                            $("#form-signin").prepend(alertError);


                            setTimeout(() => {
                                $("#alert-error").fadeOut();
                            }, 3000);
                        }
                    }
                })
            });
        });
    </script>
@endsection