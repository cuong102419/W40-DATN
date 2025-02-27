@extends('client.layout.master')

@section('title')
    Sản phẩm
@endsection

@section('content')
    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
        <div class="container">
            <div class="row flex-xl-row-reverse justify-content-between">
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-top-bar">
                                <div class="shop-top-left">
                                    <p class="pagination-line"><a href="shop.html">12</a> Product Found of <a
                                            href="shop.html">30</a></p>
                                </div>
                                <div class="shop-top-center">
                                    <nav class="product-nav">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid"
                                                aria-selected="true"><i class="fa fa-th"></i></button>
                                            <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list"
                                                aria-selected="false"><i class="fa fa-list"></i></button>
                                        </div>
                                    </nav>
                                </div>
                                <div class="shop-top-right">
                                    <div class="shop-sort">
                                        <span>Sort By :</span>
                                        <select class="form-select" aria-label="Sort select example">
                                            <option selected>Default</option>
                                            <option value="1">Popularity</option>
                                            <option value="2">Average Rating</option>
                                            <option value="3">Newsness</option>
                                            <option value="4">Price Low to High</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                    aria-labelledby="nav-grid-tab">
                                    <div class="row">
                                        @if($products->isEmpty())
                                            <p>Không tìm thấy sản phẩm nào.</p>
                                        @else
                                            @foreach($products as $product)
                                                <div class="col-sm-6 col-lg-4">
                                                    <!--== Start Product Item ==-->
                                                    <div class="product-item">
                                                        <div class="inner-content">
                                                            <div class="product-thumb">
                                                                <a href="{{route('product.detail', $product->id)}}">
                                                                    @if ($product->imageLists->isNotEmpty())
                                                                        <img src="{{ Storage::url($product->imageLists->first()->image_url) }}"
                                                                            width="270" height="274" alt="{{ $product->name }}">
                                                                    @endif
                                                                </a>
                                                                <div class="product-flag">
                                                                    <ul>
                                                                        <li class="discount">-{{ $product->discount }}%</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="product-action">
                                                                    <a class="btn-product-wishlist" href="shop-wishlist.html"><i
                                                                            class="fa fa-heart"></i></a>
                                                                    <a class="btn-product-cart" href="shop-cart.html"><i
                                                                            class="fa fa-shopping-cart"></i></a>
                                                                    <button type="button" class="btn-product-quick-view-open">
                                                                        <i class="fa fa-arrows"></i>
                                                                    </button>
                                                                    <a class="btn-product-compare" href="shop-compare.html"><i
                                                                            class="fa fa-random"></i></a>
                                                                </div>
                                                                <a class="banner-link-overlay"
                                                                    href="{{route('product.detail', $product->id)}}"></a>
                                                            </div>
                                                            <div class="product-info">
                                                                <div class="category">
                                                                    <ul>
                                                                        <li><a
                                                                                href="{{route('product.detail', $product->id)}}">{{ $product->category_id->name ?? 'Chưa có danh mục' }}</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <h4 class="title"><a
                                                                        href="{{route('product.detail', $product->id)}}">{{ $product->name }}</a></h4>
                                                                <div class="prices">
                                                                    <span
                                                                        class="price text-danger">{{ number_format($product->variants->min('price'), 2)}}đ</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--== End Product Item ==-->
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="col-12">
                                            <div class="pagination-items">
                                                <ul class="pagination justify-content-end mb--0">
                                                    <li><a class="active" href="shop.html">1</a></li>
                                                    <li><a href="shop-four-columns.html">2</a></li>
                                                    <li><a href="shop-three-columns.html">3</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!--== Start Product Item ==-->
                                            <div class="product-item product-list-item">
                                                <div class="inner-content">
                                                    <div class="product-thumb">
                                                        <a href="single-product.html">
                                                            <img src="{{ asset('client/img/shop/list-1.webp')}}" width="322"
                                                                height="360" alt="Image-HasTech">
                                                        </a>
                                                        <div class="product-flag">
                                                            <ul>
                                                                <li class="discount">-10%</li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-action">
                                                            <a class="btn-product-wishlist" href="shop-wishlist.html"><i
                                                                    class="fa fa-heart"></i></a>
                                                            <a class="btn-product-cart" href="shop-cart.html"><i
                                                                    class="fa fa-shopping-cart"></i></a>
                                                            <button type="button" class="btn-product-quick-view-open">
                                                                <i class="fa fa-arrows"></i>
                                                            </button>
                                                            <a class="btn-product-compare" href="shop-compare.html"><i
                                                                    class="fa fa-random"></i></a>
                                                        </div>
                                                        <a class="banner-link-overlay" href="shop.html"></a>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="category">
                                                            <ul>
                                                                <li><a href="shop.html">Men</a></li>
                                                                <li class="sep">/</li>
                                                                <li><a href="shop.html">Women</a></li>
                                                            </ul>
                                                        </div>
                                                        <h4 class="title"><a href="single-product.html">Leather Mens
                                                                Slipper</a></h4>
                                                        <div class="prices">
                                                            <span class="price-old">$300</span>
                                                            <span class="sep">-</span>
                                                            <span class="price">$240.00</span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                            Voluptatem quo, rerum rem soluta quisquam, repellat is deleniti
                                                            omnis culpa ea quis provident dolore esse, offici modi dolorem
                                                            nam cum eligendi enim!</p>
                                                        <a class="btn-theme btn-sm" href="shop-cart.html">Add To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--== End prPduct Item ==-->
                                        </div>
                                        <div class="col-md-12">
                                            <!--== Start Product Item ==-->
                                            <div class="product-item product-list-item">
                                                <div class="inner-content">
                                                    <div class="product-thumb">
                                                        <a href="single-product.html">
                                                            <img src="{{ asset('client/img/shop/list-2.webp')}}" width="322"
                                                                height="360" alt="Image-HasTech">
                                                        </a>
                                                        <div class="product-action">
                                                            <a class="btn-product-wishlist" href="shop-wishlist.html"><i
                                                                    class="fa fa-heart"></i></a>
                                                            <a class="btn-product-cart" href="shop-cart.html"><i
                                                                    class="fa fa-shopping-cart"></i></a>
                                                            <button type="button" class="btn-product-quick-view-open">
                                                                <i class="fa fa-arrows"></i>
                                                            </button>
                                                            <a class="btn-product-compare" href="shop-compare.html"><i
                                                                    class="fa fa-random"></i></a>
                                                        </div>
                                                        <a class="banner-link-overlay" href="shop.html"></a>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="category">
                                                            <ul>
                                                                <li><a href="shop.html">Men</a></li>
                                                                <li class="sep">/</li>
                                                                <li><a href="shop.html">Women</a></li>
                                                            </ul>
                                                        </div>
                                                        <h4 class="title"><a href="single-product.html">Quickiin Mens
                                                                shoes</a></h4>
                                                        <div class="prices">
                                                            <span class="price">$240.00</span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                            Voluptatem quo, rerum rem soluta quisquam, repellat is deleniti
                                                            omnis culpa ea quis provident dolore esse, offici modi dolorem
                                                            nam cum eligendi enim!</p>
                                                        <a class="btn-theme btn-sm" href="shop-cart.html">Add To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--== End prPduct Item ==-->
                                        </div>
                                        <div class="col-md-12">
                                            <!--== Start Product Item ==-->
                                            <div class="product-item product-list-item">
                                                <div class="inner-content">
                                                    <div class="product-thumb">
                                                        <a href="single-product.html">
                                                            <img src="{{ asset('client/img/shop/list-3.webp')}}" width="322"
                                                                height="360" alt="Image-HasTech">
                                                        </a>
                                                        <div class="product-flag">
                                                            <ul>
                                                                <li class="discount">-10%</li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-action">
                                                            <a class="btn-product-wishlist" href="shop-wishlist.html"><i
                                                                    class="fa fa-heart"></i></a>
                                                            <a class="btn-product-cart" href="shop-cart.html"><i
                                                                    class="fa fa-shopping-cart"></i></a>
                                                            <button type="button" class="btn-product-quick-view-open">
                                                                <i class="fa fa-arrows"></i>
                                                            </button>
                                                            <a class="btn-product-compare" href="shop-compare.html"><i
                                                                    class="fa fa-random"></i></a>
                                                        </div>
                                                        <a class="banner-link-overlay" href="shop.html"></a>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="category">
                                                            <ul>
                                                                <li><a href="shop.html">Men</a></li>
                                                                <li class="sep">/</li>
                                                                <li><a href="shop.html">Women</a></li>
                                                            </ul>
                                                        </div>
                                                        <h4 class="title"><a href="single-product.html">Rexpo Womens
                                                                shoes</a></h4>
                                                        <div class="prices">
                                                            <span class="price-old">$300</span>
                                                            <span class="sep">-</span>
                                                            <span class="price">$240.00</span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                            Voluptatem quo, rerum rem soluta quisquam, repellat is deleniti
                                                            omnis culpa ea quis provident dolore esse, offici modi dolorem
                                                            nam cum eligendi enim!</p>
                                                        <a class="btn-theme btn-sm" href="shop-cart.html">Add To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--== End prPduct Item ==-->
                                        </div>
                                        <div class="col-md-12">
                                            <!--== Start Product Item ==-->
                                            <div class="product-item product-list-item">
                                                <div class="inner-content">
                                                    <div class="product-thumb">
                                                        <a href="single-product.html">
                                                            <img src="{{ asset('client/img/shop/list-4.webp')}}" width="322"
                                                                height="360" alt="Image-HasTech">
                                                        </a>
                                                        <div class="product-action">
                                                            <a class="btn-product-wishlist" href="shop-wishlist.html"><i
                                                                    class="fa fa-heart"></i></a>
                                                            <a class="btn-product-cart" href="shop-cart.html"><i
                                                                    class="fa fa-shopping-cart"></i></a>
                                                            <button type="button" class="btn-product-quick-view-open">
                                                                <i class="fa fa-arrows"></i>
                                                            </button>
                                                            <a class="btn-product-compare" href="shop-compare.html"><i
                                                                    class="fa fa-random"></i></a>
                                                        </div>
                                                        <a class="banner-link-overlay" href="shop.html"></a>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="category">
                                                            <ul>
                                                                <li><a href="shop.html">Men</a></li>
                                                                <li class="sep">/</li>
                                                                <li><a href="shop.html">Women</a></li>
                                                            </ul>
                                                        </div>
                                                        <h4 class="title"><a href="single-product.html">Modern Smart
                                                                Shoes</a></h4>
                                                        <div class="prices">
                                                            <span class="price">$240.00</span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                            Voluptatem quo, rerum rem soluta quisquam, repellat is deleniti
                                                            omnis culpa ea quis provident dolore esse, offici modi dolorem
                                                            nam cum eligendi enim!</p>
                                                        <a class="btn-theme btn-sm" href="shop-cart.html">Add To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--== End prPduct Item ==-->
                                        </div>
                                        <div class="col-md-12">
                                            <!--== Start Product Item ==-->
                                            <div class="product-item product-list-item">
                                                <div class="inner-content">
                                                    <div class="product-thumb">
                                                        <a href="single-product.html">
                                                            <img src="{{ asset('client/img/shop/list-5.webp')}}" width="322"
                                                                height="360" alt="Image-HasTech">
                                                        </a>
                                                        <div class="product-flag">
                                                            <ul>
                                                                <li class="discount">-10%</li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-action">
                                                            <a class="btn-product-wishlist" href="shop-wishlist.html"><i
                                                                    class="fa fa-heart"></i></a>
                                                            <a class="btn-product-cart" href="shop-cart.html"><i
                                                                    class="fa fa-shopping-cart"></i></a>
                                                            <button type="button" class="btn-product-quick-view-open">
                                                                <i class="fa fa-arrows"></i>
                                                            </button>
                                                            <a class="btn-product-compare" href="shop-compare.html"><i
                                                                    class="fa fa-random"></i></a>
                                                        </div>
                                                        <a class="banner-link-overlay" href="shop.html"></a>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="category">
                                                            <ul>
                                                                <li><a href="shop.html">Men</a></li>
                                                                <li class="sep">/</li>
                                                                <li><a href="shop.html">Women</a></li>
                                                            </ul>
                                                        </div>
                                                        <h4 class="title"><a href="single-product.html">Primitive Mens
                                                                shoes</a></h4>
                                                        <div class="prices">
                                                            <span class="price">$240.00</span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                            Voluptatem quo, rerum rem soluta quisquam, repellat is deleniti
                                                            omnis culpa ea quis provident dolore esse, offici modi dolorem
                                                            nam cum eligendi enim!</p>
                                                        <a class="btn-theme btn-sm" href="shop-cart.html">Add To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--== End prPduct Item ==-->
                                        </div>
                                        <div class="col-md-12">
                                            <!--== Start Product Item ==-->
                                            <div class="product-item product-list-item">
                                                <div class="inner-content">
                                                    <div class="product-thumb">
                                                        <a href="single-product.html">
                                                            <img src="{{ asset('client/img/shop/list-6.webp')}}" width="322"
                                                                height="360" alt="Image-HasTech">
                                                        </a>
                                                        <div class="product-action">
                                                            <a class="btn-product-wishlist" href="shop-wishlist.html"><i
                                                                    class="fa fa-heart"></i></a>
                                                            <a class="btn-product-cart" href="shop-cart.html"><i
                                                                    class="fa fa-shopping-cart"></i></a>
                                                            <button type="button" class="btn-product-quick-view-open">
                                                                <i class="fa fa-arrows"></i>
                                                            </button>
                                                            <a class="btn-product-compare" href="shop-compare.html"><i
                                                                    class="fa fa-random"></i></a>
                                                        </div>
                                                        <a class="banner-link-overlay" href="shop.html"></a>
                                                    </div>
                                                    <div class="product-info">
                                                        <div class="category">
                                                            <ul>
                                                                <li><a href="shop.html">Men</a></li>
                                                                <li class="sep">/</li>
                                                                <li><a href="shop.html">Women</a></li>
                                                            </ul>
                                                        </div>
                                                        <h4 class="title"><a href="single-product.html">Leather Mens
                                                                Slipper</a></h4>
                                                        <div class="prices">
                                                            <span class="price-old">$300</span>
                                                            <span class="sep">-</span>
                                                            <span class="price">$240.00</span>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                                            Voluptatem quo, rerum rem soluta quisquam, repellat is deleniti
                                                            omnis culpa ea quis provident dolore esse, offici modi dolorem
                                                            nam cum eligendi enim!</p>
                                                        <a class="btn-theme btn-sm" href="shop-cart.html">Add To Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--== End prPduct Item ==-->
                                        </div>
                                        <div class="col-12">
                                            <div class="pagination-items">
                                                <ul class="pagination justify-content-end mb--0">
                                                    <li><a class="active" href="shop.html">1</a></li>
                                                    <li><a href="shop-four-columns.html">2</a></li>
                                                    <li><a href="shop-three-columns.html">3</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="shop-sidebar">
                        <div class="shop-sidebar-category">
                            <h4 class="sidebar-title">Danh mục</h4>
                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('product.index', ['category' => $category->id]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="shop-sidebar-brand">
                            <h4 class="sidebar-title">Thương hiệu</h4>
                            <div class="sidebar-brand">
                                <ul class="brand-list mb--0">
                                    @foreach ($brands as $brand)
                                        <li>
                                            <a href="{{ route('product.index', ['brand' => $brand->id]) }}">
                                                {{ $brand->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="shop-sidebar-price-range">
                            <h4 class="sidebar-title">Price Filter</h4>
                            <div class="sidebar-price-range">
                                <div id="price-range"></div>
                            </div>
                        </div>

                        <div class="shop-sidebar-color">
                            <h4 class="sidebar-title">Color</h4>
                            <div class="sidebar-color">
                                <ul class="color-list">
                                    <li data-bg-color="#39ed8c" class="active"></li>
                                    <li data-bg-color="#a6ed42"></li>
                                    <li data-bg-color="#daed39"></li>
                                    <li data-bg-color="#eed739"></li>
                                    <li data-bg-color="#eca23a"></li>
                                    <li data-bg-color="#f36768"></li>
                                    <li data-bg-color="#e14755"></li>
                                    <li data-bg-color="#dc83a3"></li>
                                    <li data-bg-color="#dc82da"></li>
                                    <li data-bg-color="#9a82dd"></li>
                                    <li data-bg-color="#82c2db"></li>
                                    <li data-bg-color="#6bd6b0"></li>
                                    <li data-bg-color="#9ed76b"></li>
                                    <li data-bg-color="#c8c289"></li>
                                </ul>
                            </div>
                        </div>

                        <div class="shop-sidebar-size">
                            <h4 class="sidebar-title">Size</h4>
                            <div class="sidebar-size">
                                <ul class="size-list">
                                    <li><a href="shop.html">S <span>(6)</span></a></li>
                                    <li><a href="shop.html">M <span>(4)</span></a></li>
                                    <li><a href="shop.html">L <span>(2)</span></a></li>
                                    <li><a href="shop.html">XL <span>(6)</span></a></li>
                                    <li><a href="shop.html">XXL <span>(12)</span></a></li>
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Area Wrapper ==-->
@endsection