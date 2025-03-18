@extends('client.layout.master')

@section('title')
Thanh toán
@endsection

@section('content')
<!--== Start Shopping Checkout Area Wrapper ==-->
<section class="shopping-checkout-wrap">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="checkout-page-coupon-wrap">
                    <!--== Start Checkout Coupon Accordion ==-->
                    <div class="coupon-accordion" id="CouponAccordion">
                        <div class="card">
                            <h3>
                                <i class="fa fa-info-circle"></i>
                                Bạn có mã giảm giá?
                                <a href="#/" data-bs-toggle="collapse" data-bs-target="#couponaccordion">Click vào đây để nhập</a>
                            </h3>
                            <div id="couponaccordion" class="collapse" data-bs-parent="#CouponAccordion">
                                <div class="card-body">
                                    <div class="apply-coupon-wrap mb-60">
                                        <form action="{{ route('order.apply-voucher') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="code" placeholder="Nhập mã giảm giá" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn-coupon">Áp dụng</button>
                                                </div>
                                            </div>
                                        </form>
                                        @if(session('error'))
                                        <p class="text-danger mt-2">{{ session('error') }}</p>
                                        @endif
                                        @if(session('success'))
                                        <p class="text-success mt-2">{{ session('success') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--== End Checkout Coupon Accordion ==-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <!--== Start Billing Accordion ==-->
                <div class="checkout-billing-details-wrap">
                    <h2 class="title">Chi tiết thanh toán</h2>
                    <div class="billing-form-wrap">
                        <form id="checkout" action="{{ route('order.create') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="l_name">Họ tên <span class="required" title="required">*</span></label>
                                        <input id="l_name" name="fullname" type="text" class="form-control" placeholder="Nhập họ tên." value="{{ Auth::user()->name ?? '' }}">
                                        @error('fullname')
                                        <span class="text-danger small mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="street-address">Địa chỉ <span class="required" title="required">*</span></label>
                                        <input id="street-address" name="address" type="text" class="form-control" placeholder="Nhập địa chỉ." value="{{ Auth::user()->address ?? '' }}">
                                        @error('address')
                                        <span class="text-danger small mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="phone">Số điên thoại <span class="required" title="required">*</span></label>
                                        <input id="phone" name="phone_number" type="phone" class="form-control" placeholder="Nhập số điện thoại." value="{{ Auth::user()->phone_number ?? '' }}">
                                        @error('phone_number')
                                        <span class="text-danger small mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" data-margin-bottom="30">
                                        <label for="email">Địa chỉ email <span class="required" title="required">*</span></label>
                                        <input id="email" name="email" type="email" class="form-control" placeholder="Nhập email." value="{{ Auth::user()->email ?? '' }}">
                                        @error('email')
                                        <span class="text-danger small mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input id="payment_method" type="hidden" name="payment_method" class="form-control" value="">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb--0">
                                        <label for="order-notes">Ghi chú (Không bắt buộc)</label>
                                        <textarea name="note" id="order-notes" class="form-control" placeholder="Thêm ghi chú cho đơn hàng của bạn."></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--== End Billing Accordion ==-->
            </div>
            <div class="col-lg-6">
                <!--== Start Order Details Accordion ==-->
                <div class="checkout-order-details-wrap">
                    <div class="order-details-table-wrap table-responsive">
                        <h2 class="title mb-25">Đơn hàng của bạn</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2" class="product-name text-center">Sản phẩm</th>
                                    <th class="product-total">Giá</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @foreach (session('cart', []) as $cart)
                                <tr class="cart-item">
                                    <td class="product-image"><img src="{{ Storage::url($cart['image']) }}" width="80" alt=""></td>
                                    <td class="product-name ps-3">
                                        {{ $cart['name'] }} <span class="product-quantity">×
                                            {{ $cart['quantity'] }}</span>
                                        <div class="d-flex">
                                            <span>Size: {{ $cart['size'] }}</span>
                                            <div>
                                                <span class="rounded-circle border border-secondary shadow ms-2" style="width: 17px; height: 17px; background-color: {{ $cart['color'] }}; display: inline-block;">
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-total">{{ number_format($cart['price']) }}đ</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot class="table-foot">
                                <tr class="cart-subtotal">
                                    <th colspan="2">Tổng cộng</th>
                                    <td>{{ number_format($subTotal) }}đ</td>
                                </tr>
                                <tr class="shipping">
                                    <th colspan="2">Shipping</th>
                                    <td>Giá cố định: 100.000đ</td>
                                </tr>
                                <tr class="">
                                    <th colspan="2">Khuyến mãi</th>
                                    <td>
                                        @if(session()->has('voucher'))
                                        -{{ number_format(session('voucher.value')) }}đ
                                        @else
                                        Không có
                                        @endif
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <th colspan="2">
                                        <h5>Thành tiền</h5>
                                    </th>
                                    <td>
                                        <h5 class="text-danger">{{ number_format($subTotal - session('voucher.value', 0)) }}đ</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="shop-payment-method">
                            <div id="PaymentMethodAccordion">
                                <div class="card">
                                    <div class="card-header">
                                        <input type="radio" name="payment_method" value="COD" id="payment_cod" checked>
                                        <label for="payment_cod">Thanh toán khi nhận hàng (COD)</label>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <input type="radio" name="payment_method" value="MOMO" id="payment_momo">
                                        <label for="payment_momo">Ví điện tử MOMO</label>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <input type="radio" name="payment_method" value="ATM" id="payment_vnpay">
                                        <label for="payment_vnpay">Chuyển khoản ngân hàng</label>
                                    </div>
                                </div>
                            </div>
                            @if (!Auth::check())
                            <p class="p-text">Hãy đăng nhập để có thể theo dõi đơn hàng của bạn <a href="{{ route('signin') }}">Đăng nhập ngay.</a></p>
                            @endif
                            <div class="agree-policy mt-5">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" required id="privacy" class="custom-control-input visually-hidden">
                                    <label for="privacy" class="custom-control-label">Tôi đồng ý với điều
                                        khoản và điều kiện khi mua hàng <span class="required">*</span></label>
                                </div>
                            </div>
                            <button type="submit" class="btn-theme w-100">Thanh toán</button>
                        </div>
                    </div>
                </div>
                <!--== End Order Details Accordion ==-->
            </div>
        </div>
    </div>
</section>
<!--== End Shopping Checkout Area Wrapper ==-->

<script src="{{ asset('client/js/checkout.js') }}"></script>
@endsection
