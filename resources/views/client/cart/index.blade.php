@extends('client.layout.master')

@section('title')
Giỏ hàng
@endsection

@section('content')
<!--== Start Blog Area Wrapper ==-->
<section class="shopping-cart-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shopping-cart-form table-responsive">
                    <form action="#" method="post">
                        <table class="table text-center">
                            <thead>

                                <tr>

                                    <th class="product-remove">&nbsp;</th>
                                    <th class="product-thumb">&nbsp;</th>
                                    <th class="product-name">Sản phẩm</th>
                                    <th class="product-price">Giá</th>
                                    <th class="product-quantity">Số lượng</th>
                                    <th class="product-subtotal">Tổng</th>
                                </tr>
                            </thead>
                            <option>...</option>
                            </select>
                            <tbody>

                                @foreach($cart as $item)
                                <tr class="cart-product-item">
                                    <td class="product-remove"  >
                                 {{-- @if(!empty($item) && isset($item['id']))
                                        <form action="{{ route('cart.remove', ['id' => $item['id']]) }}" method="POST">
                                            @csrf
                                            @method('DELETE') --}}
                                            <button type="submit" style="background: none; border: none; cursor: pointer;">
                                                <i class="fas fa-trash-alt" style="color: red; font-size: 20px;"></i>
                                            </button>
                                        {{-- </form> --}}
                                        {{-- @else
                                        <p>Dữ liệu sản phẩm không hợp lệ</p>
                                        @endif --}}
                                    </td>
                                    <!-- Cột Hình ảnh -->
                                    <td class="product-thumb">
                                        <img src="{{ $item['attributes']['image'] ?? asset('default-image.jpg') }}" width="50">
                                    </td>

                                    <!-- Cột Tên sản phẩm -->
                                    <td class="product-name">{{ $item['name'] ?? 'Sản phẩm không xác định' }}</td>

                                    <!-- Cột Giá -->
                                    <td class="product-price">{{ number_format($item['price'] ?? 0, 0, ',', '.') }} VND</td>

                                    <!-- Cột Số lượng + Cập nhật -->

                                    <td class="product-quantity">
                                        <div class="pro-qty">
                                            <input type="text" name="quantity" value="{{ $item['quantity'] ?? 1 }}" min="1" >
                                        </div>
                                    </td>

                                    <!-- Cột Thành tiền -->
                                    <td  class="product-subtotal">{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }} VND</td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tr class="actions">
                                <td class="border-0" colspan="6">
                                    <button type="submit" class="update-cart" disabled>Update cart</button>
                                    <button type="submit" class="clear-cart">Clear Cart</button>
                                    <a href=" #" class="btn-theme btn-flat">Continue Shopping</a>
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
                    <span data-bs-toggle="collapse" data-bs-target="#CategoriesTwo" aria-expanded="true" role="button">Calculate shipping</span>
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
                                        <input type="text" id="stateCounty" class="form-control" placeholder="State / County">
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
                                        <input type="text" id="postcodeZip" class="form-control" placeholder="Postcode / ZIP">
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
                                    <input type="text" id="couponCode" class="form-control" placeholder="Enter your coupon code..">
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
    </div>
</section>
<!--== End Blog Area Wrapper ==-->
@endsection
