@extends('client.layout.master')

@section('title')
Sản phẩm yêu thích
@endsection

@section('content')
<!--== Start Wishlist Area Wrapper ==-->
<section class="shopping-wishlist-area">
    <div class="container">
        @if (session('wishlist'))
        <div class="row">
            <div class="col-md-12">
                <div class="shopping-wishlist-table table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th class="product-remove">&nbsp;</th>
                                <th class="product-thumb">&nbsp;</th>
                                <th class="product-name">Sản phẩm</th>
                                <th class="product-stock-status">Trạng thái</th>
                                <th class="product-price">Giá</th>
                                <th class="product-action">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (session('wishlist') as $wishlist)
                            <tr class="cart-wishlist-item">
                                <td class="product-remove">
                                    <a href="#/"><i class="fa fa-trash-o"></i></a>
                                </td>
                                <td class="product-thumb">
                                    <a href="{{ route('product.detail', $wishlist['product_id'] ?? 0) }}">
                                        <img src="{{ Storage::url($wishlist['image']) }}" width="100" alt="Image-HasTech">
                                    </a>
                                </td>
                                <td class="product-name">
                                    <div>
                                        <h4 class="fw-bold text-center">
                                            <a href="{{ route('product.detail', $wishlist['product_id'] ?? 0) }}" class="text-dark">{{ $wishlist['name'] }}</a>
                                        </h4>
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <span class="fw-bold small">Kích cỡ: {{ $wishlist['size'] ?? 0 }}</span>
                                            </div>
                                            <div class="col-auto d-flex align-items-center">
                                                <span class="fw-bold small">Màu sắc:</span>
                                                <span class="rounded-circle border border-secondary shadow ms-2" style="width: 22px; height: 22px; background-color: {{ $wishlist['color'] ?? 0 }}; display: inline-block;">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="product-stock-status">
                                    <span class="stock">Còn hàng</span>
                                </td>
                                <td class="product-price">
                                    <span class="price text-danger"><strong>{{ number_format($wishlist['price']) }}đ</strong></span>
                                </td>
                                <td class="product-action">
                                    <a class="btn-cart" href="shop-cart.html">Add to cart</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!--== End Wishlist Area Wrapper ==-->
@endsection