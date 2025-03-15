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
                            <form id="update-cart" action="{{ route('cart.update') }}" method="post">
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
                                                    <a href="{{ route('cart.delete.product', $cart['id']) }}" class="delete-item-cart text-danger"><i
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
                                            <a href="{{ route('cart.delete') }}" class="clear-cart btn-theme" id="clear-cart">Xóa giỏ hàng</a>
                                            <a href="{{ route('product.index') }}" class="btn-theme btn-flat">Tiếp tục mua sắm</a>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row row-gutter-50 justify-content-center">
                    <div class="col-md-12 col-lg-6">
                        <div class="shipping-form-cart-totals">
                            <div class="section-title-cart">
                                <h3 class="text-center">Tổng giỏ hàng</h3>
                            </div>
                            <div class="cart-total-table">
                                <table class="table">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <td>
                                                <p class="value">Tổng giá:</p>
                                            </td>
                                            <td>
                                                <p class="price">{{ number_format($total) }}đ</p>
                                            </td>
                                        </tr>
                                        <tr class="shipping">
                                            <td>
                                                <p class="value">Vận chuyển:</p>
                                            </td>
                                            <td>
                                                <p class="price">0</p>
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <td>
                                                <h6 class="value">Tổng:</h6>
                                            </td>
                                            <td>
                                                <h6 class="price text-danger">{{ number_format($total) }}đ</h6>
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