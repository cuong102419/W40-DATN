<!DOCTYPE html>
<html lang="zxx">


<!-- Mirrored from htmldemo.net/shome/shome/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jan 2025 15:04:17 GMT -->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Shome - Shoes eCommerce Website Template" />
  <meta name="keywords" content="footwear, shoes, modern, shop, store, ecommerce, responsive, e-commerce" />
  <meta name="author" content="codecarnival" />

  <title>@yield('title')</title>

  <!--== Favicon ==-->
  <link rel="shortcut icon" href="{{ asset('client/img/favicon.ico')}}" type="image/x-icon" />

  {{-- Css file --}}
  @include('client.layout.partials.css')

  <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
    <![endif]-->
</head>

<body>

  <!--wrapper start-->
  <div class="wrapper">

    <!--== Start Header Wrapper ==-->
    @include('client.layout.partials.header')
    <!--== End Header Wrapper ==-->

    <main class="main-content">
        @yield('content')
    </main>

    <!--== Start Footer Area Wrapper ==-->
    @include('client.layout.partials.footer')
    <!--== End Footer Area Wrapper ==-->

    <!--== Scroll Top Button ==-->
    <div id="scroll-to-top" class="scroll-to-top"><span class="fa fa-angle-up"></span></div>

    <!--== Start Quick View Menu ==-->
    <aside class="product-quick-view-modal">
      <div class="product-quick-view-inner">
        <div class="product-quick-view-content">
          <button type="button" class="btn-close">
            <span class="close-icon"><i class="fa fa-close"></i></span>
          </button>
          <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
              <div class="thumb">
                <img src="{{ asset('client/img/shop/product-single/1.webp')}}" width="570" height="541" alt="Alan-Shop">
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
              <div class="content">
                <h4 class="title">Space X Bag For Office</h4>
                <div class="prices">
                  <del class="price-old">$85.00</del>
                  <span class="price">$70.00</span>
                </div>
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                  classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin
                  professor at Hampden-Sydney College in Virginia,</p>
                <div class="quick-view-select">
                  <div class="quick-view-select-item">
                    <label for="forSize" class="form-label">Size:</label>
                    <select class="form-select" id="forSize" required>
                      <option selected value="">s</option>
                      <option>m</option>
                      <option>l</option>
                      <option>xl</option>
                    </select>
                  </div>
                  <div class="quick-view-select-item">
                    <label for="forColor" class="form-label">Color:</label>
                    <select class="form-select" id="forColor" required>
                      <option selected value="">red</option>
                      <option>green</option>
                      <option>blue</option>
                      <option>yellow</option>
                      <option>white</option>
                    </select>
                  </div>
                </div>
                <div class="action-top">
                  <div class="pro-qty">
                    <input type="text" id="quantity20" title="Quantity" value="1" />
                  </div>
                  <button class="btn btn-black">Add to cart</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="canvas-overlay"></div>
    </aside>
    <!--== End Quick View Menu ==-->

    <!--== Start Aside Cart Menu ==-->
    @include('client.layout.partials.asidecart')
    <!--== End Aside Cart Menu ==-->

    <!--== Start Aside Search Menu ==-->
    <aside class="aside-search-box-wrapper offcanvas offcanvas-top" tabindex="-1" id="AsideOffcanvasSearch"
      aria-labelledby="offcanvasTopLabel">
      <div class="offcanvas-header">
        <h5 class="d-none" id="offcanvasTopLabel">Aside Search</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
            class="pe-7s-close"></i></button>
      </div>
      <div class="offcanvas-body">
        <div class="container pt--0 pb--0">
          <div class="search-box-form-wrap">
            <div class="search-note">
              <p>Start typing and press Enter to search</p>
            </div>
            <form action="#" method="post">
              <div class="search-form position-relative">
                <label for="search-input" class="visually-hidden">Search</label>
                <input id="search-input" type="search" class="form-control" placeholder="Search entire store…">
                <button class="search-button"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </aside>
    <!--== End Aside Search Menu ==-->

    <!--== Start Side Menu ==-->
    <div class="off-canvas-wrapper offcanvas offcanvas-start" tabindex="-1" id="AsideOffcanvasMenu"
      aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h1 id="offcanvasExampleLabel"></h1>
        <button class="btn-menu-close" data-bs-dismiss="offcanvas" aria-label="Close">menu <i
            class="fa fa-chevron-left"></i></button>
      </div>
      <div class="offcanvas-body">
        <div class="info-items">
          <ul>
            <li class="number"><a href="tel://0123456789"><i class="fa fa-phone"></i>+00 123 456 789</a></li>
            <li class="email"><a href="mailto://demo@example.com"><i class="fa fa-envelope"></i>demo@example.com</a>
            </li>
            <li class="account"><a href="account-login.html"><i class="fa fa-user"></i>Account</a></li>
          </ul>
        </div>
        <!-- Mobile Menu Start -->
        <div class="mobile-menu-items">
          <ul class="nav-menu">
            <li><a href="#">Home</a>
              <ul class="sub-menu">
                <li><a href="index.html">Home One</a></li>
                <li><a href="index-two.html">Home Two</a></li>
              </ul>
            </li>
            <li><a href="about-us.html">About</a></li>
            <li><a href="#">Pages</a>
              <ul class="sub-menu">
                <li><a href="account.html">Account</a></li>
                <li><a href="account-login.html">Login</a></li>
                <li><a href="account-register.html">Register</a></li>
                <li><a href="page-not-found.html">Page Not Found</a></li>
              </ul>
            </li>
            <li><a href="#">Shop</a>
              <ul class="sub-menu">
                <li><a href="#">Shop Layout</a>
                  <ul class="sub-menu">
                    <li><a href="shop-three-columns.html">Shop 3 Column</a></li>
                    <li><a href="shop-four-columns.html">Shop 4 Column</a></li>
                    <li><a href="shop.html">Shop Left Sidebar</a></li>
                    <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                  </ul>
                </li>
                <li><a href="#">Single Product</a>
                  <ul class="sub-menu">
                    <li><a href="single-normal-product.html">Single Product Normal</a></li>
                    <li><a href="single-product.html">Single Product Variable</a></li>
                    <li><a href="single-group-product.html">Single Product Group</a></li>
                    <li><a href="single-affiliate-product.html">Single Product Affiliate</a></li>
                  </ul>
                </li>
                <li><a href="#">Others Pages</a>
                  <ul class="sub-menu">
                    <li><a href="shop-cart.html">Shopping Cart</a></li>
                    <li><a href="shop-checkout.html">Checkout</a></li>
                    <li><a href="shop-wishlist.html">Wishlist</a></li>
                    <li><a href="shop-compare.html">Compare</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#">Blog</a>
              <ul class="sub-menu">
                <li><a href="#">Blog Layout</a>
                  <ul class="sub-menu">
                    <li><a href="blog.html">Blog Grid</a></li>
                    <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                    <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                  </ul>
                </li>
                <li><a href="#">Single Blog</a>
                  <ul class="sub-menu">
                    <li><a href="blog-details-no-sidebar.html">Blog Details</a></li>
                    <li><a href="blog-details-left-sidebar.html">Blog Details Left Sidebar</a></li>
                    <li><a href="blog-details.html">Blog Details Right Sidebar</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
        <!-- Mobile Menu End -->
      </div>
    </div>
    <!--== End Side Menu ==-->

  </div>

  <!--=======================Javascript============================-->
  @include('client.layout.partials.js')

</body>


<!-- Mirrored from htmldemo.net/shome/shome/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jan 2025 15:04:43 GMT -->

</html>