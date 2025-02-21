<header class="main-header-wrapper position-relative">
    <div class="header-top">
        <div class="pt--3 pb--0 ps-3 pe-3">
            <div class="row">
                <div class="col-12">
                    <div class="header-top-align">
                        <div class="header-top-align-start">
                            <div class="desc">
                                <p>World Wide Completely Free Returns and Free Shipping</p>
                            </div>
                        </div>
                        <div class="header-top-align-end">
                            <div class="header-info-items">
                                <div class="info-items">
                                    <ul>
                                        <li class="number"><i class="fa fa-phone"></i><a href="tel://0123456789">+00 123
                                                456 789</a>
                                        </li>
                                        <li class="email"><i class="fa fa-envelope"></i><a
                                                href="mailto://demo@example.com">demo@example.com</a></li>
                                        <li class="account" style="display: flex"><i class="fa fa-user"></i>
                                            <a href="#" class="nav-link dropdown-toggle mt-1" data-bs-toggle="dropdown">
                                                <span class="d-none d-lg-inline-flex">Acount</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                                                <a href="{{route('dashboard.index')}}" class="dropdown-item fas fa-user-shield">Admin</a>
                                                <a href="#" class="dropdown-item">Profile</a>
                                                <a href="{{route('login')}}" class="dropdown-item">Login</a>
                                                <a href="#" class="dropdown-item">Logout</a>
                                            </div>
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
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="header-middle-align">
                        <div class="header-middle-align-start">
                            <div class="header-logo-area">
                                <a href="{{ route('home') }}">
                                    <img class="logo-main" src="{{ asset('client/img/logo1.webp')}}" width="170"
                                        height="34" alt="Logo" />
                                    <img class="logo-light" src="{{ asset('client/img/logo-light.webp')}}" width="131"
                                        height="34" alt="Logo" />
                                </a>
                            </div>
                        </div>
                        <div class="header-middle-align-center">
                            <div class="header-search-area">
                                <form class="header-searchbox">
                                    <input type="search" class="form-control" placeholder="Search">
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
                                        <sup class="shop-count">02</sup>
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
    </div>
    <div class="header-area header-default">
        <div class="container-fluid p-0">
            <div class="row no-gutter align-items-center position-relative">
                <div class="col-12">
                    <div class="header-align">
                        <div class="header-navigation-area position-relative w-100 container">
                            <ul class="main-menu nav justify-content-between">
                                <li class=""><a class="fs-6 fw-bold" href="{{ route('home') }}"><span>Trang chủ</span></a>
                                </li>
                                <li><a class="fs-6 fw-bold" href="{{ route('product.index') }}"><span>Sản phẩm</span></a></li>
                                <li class=""><a class="fs-6 fw-bold" href="#/"><span>Về chúng tôi</span></a>
                                </li>
                                <li><a class="fs-6 fw-bold" href="{{ route('blog.index') }}"><span>Tin tức</span></a>
                                </li>
                                <li><a class="fs-6 fw-bold" href="{{ route('contact.form') }}"><span>Liên hệ</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>