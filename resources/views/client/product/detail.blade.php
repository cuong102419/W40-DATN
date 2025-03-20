@extends('client.layout.master')

@section('title')
    Chi tiết sản phẩm
@endsection

@section('content')
    <!--== Start Product Single Area Wrapper ==-->
    <section class="product-area product-single-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-single-item">
                        <div class="row">
                            <div class="col-xl-6">
                                <!--== Start Product Thumbnail Area ==-->
                                <div class="product-single-thumb">
                                    <div class="swiper-container single-product-thumb single-product-thumb-slider">
                                        <div class="swiper-wrapper">
                                            @foreach ($product->imageLists as $image)
                                                <div class="swiper-slide">
                                                    <a class="lightbox-image" data-fancybox="gallery"
                                                        href="{{asset('client/img/shop/product-single/1.webp')}}">
                                                        <img src="{{ Storage::url($image->image_url) }}" width="570"
                                                            height="541" alt="Image-HasTech">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="swiper-container single-product-nav single-product-nav-slider">
                                        <div class="swiper-wrapper">
                                            @foreach ($product->imageLists as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ Storage::url($image->image_url) }}" width="127" height="127"
                                                        alt="{{ $product->name }}">
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <!--== End Product Thumbnail Area ==-->
                            </div>
                            <div class="col-xl-6">
                                <!--== Start Product Info Area ==-->
                                <div class="product-single-info">
                                    <h3 class="main-title">{{ $product->name }}</h3>
                                    <div class="prices">
                                        @if ($product->discount)
                                            <span
                                                class="price text-danger">{{ str_replace(',', '.', number_format($product->variants->min('price') * (1 - $product->discount / 100))) }}
                                                VND</span>
                                        @else
                                            <span
                                                class="price text-danger">{{ str_replace(',', '.', number_format($product->variants->min('price'))) }}
                                                VND</span>
                                        @endif
                                    </div>

                                    <div class="rating-box-wrap">
                                        <div class="rating-box">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="review-status">
                                            <a href="javascript:void(0)">(5 Customer Review)</a>
                                        </div>
                                    </div>
                                    <form id="add-to-cart" action="{{ route('cart.add', $product->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="color" id="selected-color">
                                        <input type="hidden" name="size" id="selected-size">
                                        <input type="hidden" id="product-discount" value="{{ $product->discount }}">

                                        <p id="stock-status">Chọn màu và size</p>
                                        <ul class="quantity-list">
                                            @foreach($product->variants as $variant)
                                                <li class="quantity-option" data-color="{{ strtolower($variant->color) }}"
                                                    data-size="{{ strtolower($variant->size) }}"
                                                    data-quantity="{{ $variant->quantity }}">
                                                </li>
                                            @endforeach
                                        </ul>

                                        <script>


                                        </script>
                                        <div class="product-color">
                                            <h6 class="title">Màu</h6>
                                            <ul class="color-list">
                                                @foreach($product->variants->unique('color') as $variant)
                                                    @php
                                                        $sizes = $product->variants->where('color', $variant->color)->pluck('size')->implode(',');
                                                    @endphp
                                                    <li class="color-option" data-color="{{ strtolower($variant->color) }}"
                                                        data-size="{{ $sizes }}" data-price="{{ $variant->price }}"
                                                        style="background-color: {{ $variant->color }}">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="product-size">
                                            <h6 class="title">Size</h6>
                                            <ul class="size-list">
                                                @foreach($product->variants->unique('size')->sortBy('size') as $variant)
                                                    <li class="size-option" data-size="{{ strtolower($variant->size) }}"
                                                        data-color="{{ $variant->color }}" data-price="{{ $variant->price }}">
                                                        {{ $variant->size }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <style>
                                            .color-option.selected,
                                            .size-option.selected {
                                                border: 2px solid black;
                                                opacity: 1;
                                            }

                                            .color-option.disabled,
                                            .size-option.disabled {
                                                opacity: 0.5;
                                                pointer-events: none;
                                            }
                                        </style>
                                        <div class="product-quick-action">
                                            <div class="qty-wrap">
                                                <div class="pro-qty">
                                                    <input type="text" title="Quantity" name="quantity" value="1">
                                                </div>
                                            </div>
                                            <button class="btn-theme">Thêm vào giỏ hàng</button>
                                        </div>

                                    </form>
                                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                        @csrf
                                        {{-- Thêm vào yêu thích --}}
                                        <div class="product-wishlist-compare">
                                            <button type="submit" class="text-decoration-none btn btn-link text-danger p-3">
                                                <i class="pe-7s-like fa-lg"></i> Thêm vào yêu thích
                                            </button>
                                        </div>
                                    </form>

                                    <div class="product-info-footer">
                                        <div class="social-icons">
                                            <span>Share</span>
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-dribbble"></i></a>
                                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <!--== End Product Info Area ==-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="product-review-tabs-content">
                        <ul class="nav product-tab-nav" id="ReviewTab" role="tablist">
                            <li role="presentation">
                                <a class="active" id="information-tab" data-bs-toggle="pill" href="#information" role="tab"
                                    aria-controls="information" aria-selected="true">Thông tin</a>
                            </li>
                            <li role="presentation">
                                <a id="description-tab" data-bs-toggle="pill" href="#description" role="tab"
                                    aria-controls="description" aria-selected="false">Mô tả</a>
                            </li>
                            <li role="presentation">
                                <a id="reviews-tab" data-bs-toggle="pill" href="#reviews" role="tab" aria-controls="reviews"
                                    aria-selected="false">Đánh giá<span>(05)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content product-tab-content" id="ReviewTabContent">
                            <div class="tab-pane fade show active" id="information" role="tabpanel"
                                aria-labelledby="information-tab">
                                <div class="product-information">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim adlo minim veniam, quis nostrud
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                        irure dolor in tun tuni reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
                                        qui officia deserun mollit anim id est laborum. Sed ut perspiciatis unde omnis iste
                                        natus error sit voluptatem accusantium doloremque laudantium, totam rel aperiam,
                                        eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                                        sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
                                        fugit, sed quia consequuntur.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="product-description">
                                    <p>{!! $product->description !!}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="product-review-content">
                                    <div class="review-content-header">
                                        <h3>Customer Reviews</h3>
                                        <div class="review-info">
                                            <ul class="review-rating">
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star"></li>
                                                <li class="fa fa-star-o"></li>
                                            </ul>
                                            <span class="review-caption">Based on 5 reviews</span>
                                            <span class="review-write-btn">Write a review</span>
                                        </div>
                                    </div>

                                    <!--== Start Reviews Form Item ==-->
                                    <div class="reviews-form-area">
                                        <h4 class="title">Write a review</h4>
                                        <div class="reviews-form-content">
                                            @if(Auth::check()) 
                                                @if($hasPurchased) 
                                                    <form action="{{ route('reviews.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="for_name">Name</label>
                                                                    <input id="for_name" class="form-control" type="text" name="name"
                                                                        value="{{ Auth::user()->name }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="for_email">Email</label>
                                                                    <input id="for_email" class="form-control" type="email" name="email"
                                                                        value="{{ Auth::user()->email }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <span class="title">Rating</span>
                                                                    <div class="review-rating">
                                                                        <span class="star" data-value="1">&#9733;</span>
                                                                        <span class="star" data-value="2">&#9733;</span>
                                                                        <span class="star" data-value="3">&#9733;</span>
                                                                        <span class="star" data-value="4">&#9733;</span>
                                                                        <span class="star" data-value="5">&#9733;</span>
                                                                    </div>
                                                                    <input type="hidden" name="rating" id="rating-value">
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="for_review-title">Review Title</label>
                                                                    <input id="for_review-title" class="form-control" type="text"
                                                                        name="title" placeholder="Give your review a title">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="for_comment">Body of Review</label>
                                                                    <textarea id="for_comment" class="form-control" name="comment"
                                                                        placeholder="Write your comments here"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-submit-btn">
                                                                    <button type="submit" class="btn-submit">Post comment</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @else
                                                    <div class="alert alert-warning">
                                                        You must purchase this product before leaving a review.
                                                    </div>
                                                @endif
                                            @else
                                                <div class="alert alert-warning">
                                                    Please <a href="{{ route('login') }}">login</a> to leave a review.
                                                </div>
                                            @endif
                                        </div>
                                    </div>     
                                    <!--== Start Reviews Pagination Item ==-->
                                    <div class="review-pagination">
                                        <span class="pagination-pag">1</span>
                                        <span class="pagination-pag">2</span>
                                        <span class="pagination-next">Next »</span>
                                    </div>
                                    <!--== End Reviews Pagination Item ==-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Single Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-best-seller-area">
        <div class="container pt--0">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h3 class="title">Similar Product</h3>
                        <div class="desc">
                            <p>There are many variations of passages of Lorem Ipsum available</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-slider-wrap">
                        <div class="swiper-container product-slider-col4-container">
                            <div class="swiper-wrapper">
                                @foreach ($products as $product)
                                    <div class="swiper-slide">
                                        <div class="product-item">
                                            <div class="inner-content">
                                                <div class="product-thumb">
                                                    <a href="{{ route('product.detail', $product->id) }}">
                                                        <img src="{{ Storage::url($product->imageLists->first()?->image_url) }}"
                                                            width="270" height="274" alt="{{ $product->name }}">
                                                    </a>
                                                    <div class="product-action">
                                                        <a class="btn-product-wishlist" href="#"><i class="fa fa-heart"></i></a>
                                                        <a class="btn-product-cart" href="#"><i
                                                                class="fa fa-shopping-cart"></i></a>
                                                        <button type="button" class="btn-product-quick-view-open">
                                                            <i class="fa fa-arrows"></i>
                                                        </button>
                                                        <a class="btn-product-compare" href="#"><i class="fa fa-random"></i></a>
                                                    </div>
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
                                                    <h4 class="title">
                                                        <a
                                                            href="{{ route('product.detail', $product->id) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <div class="prices">
                                                        <span
                                                            class="price text-danger">{{ number_format($product->variants->min('price'), 2)}}đ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!--== Add Swiper Arrows ==-->
                        <div class="product-swiper-btn-wrap">
                            <div class="product-swiper-btn-prev">
                                <i class="fa fa-arrow-left"></i>
                            </div>
                            <div class="product-swiper-btn-next">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Area Wrapper ==-->
    <script>
        var cartIndexUrl = "{{ route('cart.index') }}";
        let productDiscount = @json($product->discount);
    </script>
    <script src="{{ asset('administrator/js/product.detail.js') }}"></script>










































































































    
@endsection