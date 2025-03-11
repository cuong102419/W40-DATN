@extends('client.layout.master')

@section('title')
    Giỏ hàng
@endsection

@section('content')
    <!--== Start Blog Area Wrapper ==-->
    <section class="shopping-cart-area">
        <div class="container">
            @if (session('cart'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="shopping-cart-form table-responsive">
                            <form action="{{ route('cart.update') }}" method="post">
                                @csrf
                                @method('PUT')
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th class="product-remove"></th>
                                            <th class="product-thumb"></th>
                                            <th class="product-name text-center">Sản phẩm</th>
                                            <th class="product-price">Giá</th>
                                            <th class="product-quantity">Số lượng</th>
                                            <th class="product-subtotal">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session('cart') as $cart)
                                            <tr class="cart-product-item">
                                                <td class="product-remove">
                                                    <a href="{{ route('cart.delete.product', $cart['id']) }}" class="text-danger"><i
                                                            class="fa fa-trash-o"></i></a>
                                                </td>
                                                <td class="product-thumb">
                                                    <a href="{{ route('product.detail', $cart['product_id']) }}">
                                                        <img src="{{ Storage::url($cart['image']) }}" width="100"
                                                            alt="Image-HasTech">
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <div>
                                                        <h4 class="fw-bold text-center">
                                                            <a href="{{ route('product.detail', $cart['product_id']) }}"
                                                                class="text-dark">{{ $cart['name'] }}</a>
                                                        </h4>
                                                        <div class="row justify-content-center">
                                                            <div class="col-auto">
                                                                <span class="fw-bold small">Kích cỡ: {{ $cart['size'] }}</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center">
                                                                <span class="fw-bold small">Màu sắc:</span>
                                                                <span class="rounded-circle border border-secondary shadow ms-2"
                                                                    style="width: 22px; height: 22px; background-color: {{ $cart['color'] }}; display: inline-block;">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="product-price">
                                                    <span
                                                        class="price text-danger"><strong>{{ number_format($cart['price']) }}đ</strong></span>
                                                </td>
                                                <td class="product-quantity">
                                                    <div class="pro-qty">
                                                        <input type="text" class="quantity" name="quantity[{{ $cart['id'] }}]"
                                                            title="Quantity" value="{{ $cart['quantity'] }}">
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span
                                                        class="price text-danger"><strong>{{ number_format($cart['price'] * $cart['quantity']) }}đ</strong></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tr class="actions">
                                        <td class="border-0" colspan="6">
                                            <button type="submit" class="update-cart">Cập nhật giỏ hàng</button>
                                            <a href="{{ route('cart.delete') }}" class="clear-cart btn-theme">Xóa giỏ hàng</a>
                                            <a href="{{ route('product.index') }}" class="btn-theme btn-flat">Tiếp tục mua sắm</a>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row row-gutter-50">
                    <div class="col-md-6 col-lg-4">
                        <div id="CategoriesAccordion" class="shipping-form-calculate">
                            <div class="section-title-cart">
                                <h5 class="title">Calculate Shipping</h5>
                                <div class="desc">
                                    <p>Estimate your shipping fee *</p>
                                </div>
                            </div>
                            <span data-bs-toggle="collapse" data-bs-target="#CategoriesTwo" aria-expanded="true"
                                role="button">Calculate shipping</span>
                            <div id="CategoriesTwo" class="collapse show" data-bs-parent="#CategoriesAccordion">
                                <form action="#" method="post">
                                    <div class="row row-gutter-50">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="visually-hidden" for="FormCountry">State</label>
                                                <select id="FormCountry" class="form-control">
                                                    <option selected>Select a country…</option>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="stateCounty" class="visually-hidden">State / County</label>
                                                <input type="text" id="stateCounty" class="form-control"
                                                    placeholder="State / County">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="townCity" class="visually-hidden">Town / City</label>
                                                <input type="text" id="townCity" class="form-control" placeholder="Town / City">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="postcodeZip" class="visually-hidden">Postcode / ZIP</label>
                                                <input type="text" id="postcodeZip" class="form-control"
                                                    placeholder="Postcode / ZIP">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="update-totals">Update totals</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="shipping-form-coupon">
                            <div class="section-title-cart">
                                <h5 class="title">Coupon Code</h5>
                                <div class="desc">
                                    <p>Enter your coupon code if you have one.</p>
                                </div>
                            </div>
                            <form action="#" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="couponCode" class="visually-hidden">Coupon Code</label>
                                            <input type="text" id="couponCode" class="form-control"
                                                placeholder="Enter your coupon code..">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="coupon-btn">Apply coupon</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="shipping-form-cart-totals">
                            <div class="section-title-cart">
                                <h5 class="title">Cart totals</h5>
                            </div>
                            <div class="cart-total-table">
                                <table class="table">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <td>
                                                <p class="value">Subtotal</p>
                                            </td>
                                            <td>
                                                <p class="price">£128.00</p>
                                            </td>
                                        </tr>
                                        <tr class="shipping">
                                            <td>
                                                <p class="value">Shipping</p>
                                            </td>
                                            <td>
                                                <ul class="shipping-list">
                                                    <li class="radio">
                                                        <input type="radio" name="shipping" id="radio1" checked>
                                                        <label for="radio1"><span></span> Flat Rate</label>
                                                    </li>
                                                    <li class="radio">
                                                        <input type="radio" name="shipping" id="radio2">
                                                        <label for="radio2"><span></span> Free Shipping</label>
                                                    </li>
                                                    <li class="radio">
                                                        <input type="radio" name="shipping" id="radio3">
                                                        <label for="radio3"><span></span> Local Pickup</label>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>
                                                <p class="value">Total</p>
                                            </td>
                                            <td>
                                                <p class="price">£128.00</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a class="btn-theme btn-flat" href="{{ route('order.index') }}">Thanh toán</a>

                        </div>
                    </div>
                </div>
            @else
                <h3 class="text-center mb-5">Chưa có sản phẩm nào trong giỏ hàng.</h3>
                <div class="text-center">
                    <a href=" {{ route('product.index') }}" class="btn-theme btn-sm"><i class="fa fa-arrow-left me-2"
                            aria-hidden="true"></i>Quay về trang mua sắm</a>
                </div>
            @endif
        </div>
    </section>
    <!--== End Blog Area Wrapper ==-->
@endsection