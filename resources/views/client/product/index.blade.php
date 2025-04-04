@extends('client.layout.master')

@section('title')
    Sản phẩm
@endsection

@section('content')
    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
        <div class="container">
            <div class="row justify-content-between">
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
                            <h4 class="sidebar-title">Lọc theo giá</h4>
                            <div class="sidebar-price-range">
                                <input type="text" id="amount" readonly
                                    style="border:0; color:#000000; font-weight:bold;">
                                <div id="price-range"></div>
                                <button id="filter-price" class="mt-3 btn btn-theme btn-sm mt-2"><i class="fa fa-filter me-2" aria-hidden="true"></i>Lọc</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                                                data-bs-target="#nav-grid" type="button" role="tab"
                                                aria-controls="nav-grid" aria-selected="true"><i
                                                    class="fa fa-th"></i></button>
                                            <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab"
                                                aria-controls="nav-list" aria-selected="false"><i
                                                    class="fa fa-list"></i></button>
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
                                        @if ($products->isEmpty())
                                            <p>Không tìm thấy sản phẩm nào.</p>
                                        @else
                                            @foreach ($products as $product)
                                                <div class="col-sm-6 col-lg-4">
                                                    <!--== Start Product Item ==-->
                                                    <div class="product-item">
                                                        <div class="inner-content">
                                                            <div class="product-thumb">
                                                                <a href="{{ route('product.detail', $product->id) }}">
                                                                    @if ($product->imageLists->isNotEmpty())
                                                                        <img src="{{ Storage::url($product->imageLists->first()->image_url) }}"
                                                                            width="270" height="274"
                                                                            alt="{{ $product->name }}">
                                                                    @endif
                                                                </a>
                                                                <div class="product-flag">
                                                                    <ul>
                                                                        <li class="discount">-{{ $product->discount }}%</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="product-action">
                                                                    <a class="btn-product-wishlist" href="#">
                                                                        <i class="fa fa-heart"></i>
                                                                    </a>

                                                                </div>
                                                                <a class="banner-link-overlay"
                                                                    href="{{ route('product.detail', $product->id) }}"></a>
                                                            </div>
                                                            <div class="product-info">
                                                                <div class="category">
                                                                    <ul>
                                                                        <li><a
                                                                                href="{{ route('product.detail', $product->id) }}">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <h4 class="title"><a
                                                                        href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a>
                                                                </h4>
                                                                <div class="prices">
                                                                    @if ($product->discount)
                                                                        <span
                                                                            class="price-old">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                        <span class="sep">-</span>
                                                                        <span
                                                                            class="price text-danger">{{ number_format($product->variants->min('price') * (1 - $product->discount / 100), 2) }}đ</span>
                                                                    @else
                                                                        <span
                                                                            class="price-old text-danger">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                    @endif
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

                                        @foreach ($products as $product)
                                            <div class="col-md-12">
                                                <!--== Start Product Item ==-->
                                                <div class="product-item product-list-item">
                                                    <div class="inner-content">
                                                        <div class="product-thumb">
                                                            <a href="{{ route('product.detail', $product->id) }}">
                                                                <img src="{{ Storage::url($product->imageLists->first()->image_url) }}"
                                                                    width="322" height="360"
                                                                    alt="{{ $product->name }}">
                                                            </a>

                                                            @if ($product->discount)
                                                                <div class="product-flag">
                                                                    <ul>
                                                                        <li class="discount">-{{ $product->discount }}%
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                            <form
                                                                action="{{ route('wishlist.add', ['product' => $product->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="product-action">
                                                                    <button type="submit"
                                                                        class="btn-product-wishlist border-0 bg-transparent">
                                                                        <i class="fa fa-heart text-danger"></i>
                                                                    </button>
                                                                </div>
                                                            </form>

                                                            <a class="banner-link-overlay"
                                                                href="{{ route('product.detail', $product->id) }}"></a>
                                                        </div>
                                                        <div class="product-info">
                                                            <div class="category">
                                                                <ul>
                                                                    <li><a
                                                                            href="#">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <h4 class="title"><a
                                                                    href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a>
                                                            </h4>
                                                            <div class="prices">

                                                                @if ($product->discount)
                                                                    <span
                                                                        class="price-old">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                    <span class="sep">-</span>
                                                                    <span
                                                                        class="price text-danger">{{ number_format($product->variants->min('price') * (1 - $product->discount / 100), 2) }}đ</span>
                                                                @else
                                                                    <span
                                                                        class="price-old text-danger">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                @endif

                                                            </div>
                                                            <p>{!! Str::limit($product->description, 100) !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
            </div>
        </div>
    </section>
    <script src="{{ asset('administrator/js/product.js') }}"></script>
    <!--== End Product Area Wrapper ==-->
@endsection
