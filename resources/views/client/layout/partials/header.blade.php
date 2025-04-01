<header class="main-header-wrapper position-relative">
    <div class="header-top">
        <div class="pt--3 pb--0 ps-3 pe-3">
            <div class="row">
                <div class="col-12">
                    <div class="header-top-align">
                        <div class="header-top-align-start">
                            <div class="desc">
                                <p>Vận chuyển trên toàn quốc nhanh chóng</p>
                            </div>
                        </div>
                        <div class="header-top-align-end">
                            <div class="header-info-items">
                                <div class="info-items">
                                    <ul>
                                        <li class="number"><i class="fa fa-phone"></i><a
                                                href="tel://0123456789">0988.002.157</a>
                                        </li>
                                        <li class="email"><i class="fa fa-envelope"></i><a
                                                href="mailto://demo@example.com">freaksport@gmail.com</a></li>
                                        <li class="account" style="display: flex"><i class="fa fa-user"></i>
                                            {{-- @dd(Auth::user()) --}}
                                            @if (Auth::check())
                                                <a href="#" class="nav-link dropdown-toggle mt-1" data-bs-toggle="dropdown">
                                                    <span class="d-none d-lg-inline-flex">Tài khoản</span>
                                                </a>
                                                <div
                                                    class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                                    @if (Auth::user()->role == 'staff' || Auth::user()->role == 'manager')
                                                        <a href="{{route('dashboard.index')}}"
                                                            class="dropdown-item fas fa-user-shield">Trang quản trị</a>
                                                    @endif
                                                    <a href="{{ route('order.list') }}" class="dropdown-item">Đơn hàng</a>
                                                    <a href="{{  route('profile')}}" class="dropdown-item">Hồ sơ</a>
                                                    <a href="{{  route('change-password')}}" class="dropdown-item">Đổi mật
                                                        khẩu</a>
                                                    <a href="{{  route('logout')}}" class="dropdown-item">Đăng xuất</a>
                                                </div>
                                            @else
                                                <a href="{{ route('signin.signin') }}" class="nav-link mt-1">
                                                    <span class="d-none d-lg-inline-flex">Đăng nhập</span>
                                                </a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container pt--0 pb--0">
            <div class="align-items-center">
                <div class="header-middle-align">
                    <div class="header-middle-align-start">
                        <div class="header-logo-area">
                            <a href="{{ route('home') }}">
                                <img class="logo-main" src="{{ asset('client/img/logo1.webp')}}" width="170" height="34"
                                    alt="Logo" />
                                <img class="logo-light" src="{{ asset('client/img/logo-light.webp')}}" width="131"
                                    height="34" alt="Logo" />
                            </a>
                        </div>
                    </div>
                    <div class="header-middle-align-center">
                        <div class="header-search-area">
                            <form action="{{ route('search') }}" class="header-searchbox">
                                <input type="search" name="keyword" class="form-control" placeholder="Search" required>
                                <button class="btn-submit" type="submit"><i class="pe-7s-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="header-middle-align-end">
                        <div class="header-action-area">
                            <div class="shopping-search">
                                <button class="shopping-search-btn" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#AsideOffcanvasSearch" aria-controls="AsideOffcanvasSearch"><i
                                        class="pe-7s-search icon"></i></button>
                            </div>
                            <div class="shopping-wishlist">
                                <a class="shopping-wishlist-btn" href="{{ route('wishlist.index') }}">
                                    <i class="pe-7s-like icon"></i>
                                </a>
                            </div>
                            <div class="shopping-cart ms-3">
                                <button class="shopping-cart-btn" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#AsideOffcanvasCart" aria-controls="offcanvasRightLabel">
                                    <i class="pe-7s-shopbag icon"></i>
                                    @if (session('cart'))
                                        <sup class="shop-count">{{ count(session('cart', [])) }}</sup>
                                    @endif
                                </button>
                            </div>
                            <button class="btn-menu" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
                                <i class="pe-7s-menu"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-area header-default">
        <div class="no-gutter align-items-center position-relative w-100 header-align">
            <div class="header-navigation-area container">
                <ul class="main-menu nav justify-content-between">
                    <li class=""><a class="fs-6 fw-bold" href="{{ route('home') }}"><span>Trang
                                chủ</span></a>
                    </li>
                    <li><a class="fs-6 fw-bold" href="{{ route('product.index') }}"><span>Sản
                                phẩm</span></a></li>
                    <li class=""><a class="fs-6 fw-bold" href="{{ route('about.index') }}"><span>Về chúng
                                tôi</span></a>
                    </li>
                    <li><a class="fs-6 fw-bold" href="{{ route('blog.index') }}"><span>Tin tức</span></a>
                    </li>
                    <li><a class="fs-6 fw-bold" href="{{ route('contact.form') }}"><span>Liên hệ</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- <!-- Màn hình loading -->
    <div id="loading-screen"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: white; z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="loader"></div>
        </div>
    </div>

    <style>
        /* CSS hiệu ứng loading */
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #ccc;
            border-top-color: #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("a").on("click", function (e) {
                var url = $(this).attr("href");

                if (!url || url === "#" || url.startsWith("javascript") || $(this).attr("target") === "_blank") {
                    return;
                }

                $("#loading-screen").fadeIn(300);
                e.preventDefault();

                setTimeout(function () {
                    window.location.href = url;
                }, 1000);
            });
        });
    </script> --}}

</header>