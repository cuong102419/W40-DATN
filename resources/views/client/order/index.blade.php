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
                                    Bạn có mã giảm giá
                                    <a href="#/" data-bs-toggle="collapse" data-bs-target="#couponaccordion">Click vào đây
                                        để nhập</a>
                                </h3>
                                <div id="couponaccordion" class="collapse" data-bs-parent="#CouponAccordion">
                                    <div class="card-body">
                                        <div class="apply-coupon-wrap mb-60">
                                            <form action="#" method="post">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text"
                                                                placeholder="Mã giảm giá">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button class="btn-coupon">Áp dụng giảm giá</button>
                                                    </div>
                                                </div>
                                            </form>
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
                            <form action="#" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="l_name">Họ tên <span class="required"
                                                    title="required">*</span></label>
                                            <input id="l_name" type="text" class="form-control" placeholder="Nhập họ tên.">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="street-address">Địa chỉ <span class="required"
                                                    title="required">*</span></label>
                                            <input id="street-address" type="text" class="form-control"
                                                placeholder="Nhập địa chỉ.">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone">Số điên thoại <span class="required"
                                                    title="required">*</span></label>
                                            <input id="phone" type="text" class="form-control"
                                                placeholder="Nhập số điện thoại.">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" data-margin-bottom="30">
                                            <label for="email">Địa chỉ email <span class="required"
                                                    title="required">*</span></label>
                                            <input id="email" type="text" class="form-control" placeholder="Nhập email.">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb--0">
                                            <label for="order-notes">Ghi chú (Không bắt buộc)</label>
                                            <textarea id="order-notes" class="form-control"
                                                placeholder="Thêm ghi chú cho đơn hàng của bạn."></textarea>
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
                                        <th class="product-total">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body">
                                    @foreach (session('cart', []) as $cart)
                                        <tr class="cart-item">
                                            <td class="product-image"><img src="{{ Storage::url($cart['image']) }}" width="80"
                                                    alt=""></td>
                                            <td class="product-name ps-3">
                                                {{ $cart['name'] }} <span class="product-quantity">×
                                                    {{ $cart['quantity'] }}</span>
                                                <div class="d-flex">
                                                    <span>Size: {{ $cart['size'] }}</span>
                                                    <div>
                                                        <span class="rounded-circle border border-secondary shadow ms-2"
                                                            style="width: 17px; height: 17px; background-color: {{ $cart['color'] }}; display: inline-block;">
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
                                        <td>Giá cố định: £2.00</td>
                                    </tr>
                                    <tr class="order-total">
                                        <th colspan="2">
                                            <h5>Thành tiền</h5>
                                        </th>
                                        <td>
                                            <h5 class=""></h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="shop-payment-method">
                                <div id="PaymentMethodAccordion">
                                    <div class="card">
                                        <div class="card-header" id="check_payments">
                                            <h5 class="title" data-bs-toggle="collapse" data-bs-target="#itemOne"
                                                aria-controls="itemOne" aria-expanded="true">Direct bank transfer</h5>
                                        </div>
                                        <div id="itemOne" class="collapse show" aria-labelledby="check_payments"
                                            data-bs-parent="#PaymentMethodAccordion">
                                            <div class="card-body">
                                                <p>Make your payment directly into our bank account. Please use your Order
                                                    ID as the payment reference. Your order will not be shipped until the
                                                    funds have cleared in our account.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="check_payments2">
                                            <h5 class="title" data-bs-toggle="collapse" data-bs-target="#itemTwo"
                                                aria-controls="itemTwo" aria-expanded="false">Check payments</h5>
                                        </div>
                                        <div id="itemTwo" class="collapse" aria-labelledby="check_payments2"
                                            data-bs-parent="#PaymentMethodAccordion">
                                            <div class="card-body">
                                                <p>Please send a check to Store Name, Store Street, Store Town, Store State
                                                    / County, Store Postcode.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="check_payments3">
                                            <h5 class="title" data-bs-toggle="collapse" data-bs-target="#itemThree"
                                                aria-controls="itemTwo" aria-expanded="false">Cash on delivery</h5>
                                        </div>
                                        <div id="itemThree" class="collapse" aria-labelledby="check_payments3"
                                            data-bs-parent="#PaymentMethodAccordion">
                                            <div class="card-body">
                                                <p>Pay with cash upon delivery.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="check_payments4">
                                            <h5 class="title" data-bs-toggle="collapse" data-bs-target="#itemFour"
                                                aria-controls="itemTwo" aria-expanded="false">PayPal Express Checkout <img
                                                    src="assets/img/photos/paypal2.webp" width="40" height="26"
                                                    alt="Image-HasTech"></h5>
                                        </div>
                                        <div id="itemFour" class="collapse" aria-labelledby="check_payments4"
                                            data-bs-parent="#PaymentMethodAccordion">
                                            <div class="card-body">
                                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a
                                                    PayPal account.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="p-text">Your personal data will be used to process your order, support your
                                    experience throughout this website, and for other purposes described in our <a
                                        href="#/">privacy policy.</a></p>
                                <div class="agree-policy">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="privacy" class="custom-control-input visually-hidden">
                                        <label for="privacy" class="custom-control-label">I have read and agree to the
                                            website terms and conditions <span class="required">*</span></label>
                                    </div>
                                </div>
                                <a href="account-login.html" class="btn-theme">Place order</a>
                            </div>
                        </div>
                    </div>
                    <!--== End Order Details Accordion ==-->
                </div>
            </div>
        </div>
    </section>
    <!--== End Shopping Checkout Area Wrapper ==-->
@endsection