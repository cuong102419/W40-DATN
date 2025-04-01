@extends('client.layout.master')

@section('title')
    Thông tin đơn hàng
@endsection

@section('content')
    <div class="mt-3 mb-5 container">
        <div class="row">
            <div class="col-7">
                <h5 class="text-uppercase">Đơn hàng: {{ $order->order_code }}</h5>
                <div class="mt-5 border p-4">
                    <div class="d-flex justify-content-between border-bottom pb-4">
                        <div>
                            <span>Trạng thái:</span>
                            <h3 class="{{ $status[$order->status]['class'] }} text-uppercase">
                                {{ $status[$order->status]['value'] }}
                            </h3 class="{{ $status[$order->status]['class'] }} text-uppercase">
                        </div>
                        <div>
                            Ngày tạo:
                            <div>
                                <h4 class="fw-bold">{{ $order->created_at->format('d \T\H\G m, Y') }}</h4>
                            </div>
                        </div>
                    </div>
                    <table class="table mt-4">
                        @foreach ($orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('product.detail', $item->product_variant->product->id) }}"
                                            class="me-3">
                                            <img src="{{ Storage::url($item->product_variant->product->imageLists->first()->image_url) }}"
                                                width="200" height="110" alt="">
                                        </a>
                                        <div class="ms-4">
                                            <h4 class="product-title">{{ $item->product_variant->product->name }}</h4>
                                            <div>
                                                <span>Mã sản phẩm: {{ $item->product_variant->product->sku }}</span>
                                            </div>
                                            <div>
                                                <span class=" me-3">Kích cỡ: {{ $item->product_variant->size }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class=" me-1">Màu:</span>
                                                <div class="mt-1">
                                                    <span class="rounded-circle border border-secondary shadow "
                                                        style="width: 18px; height: 18px; background-color: {{ $item->product_variant->color }}; display: inline-block;">
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <span>Số lượng: {{ $item->quantity }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @if ($order->status == 'unconfirmed')
                    <div class="mt-3">
                        <form id="cancel-order" action="{{ route('order.cancel', $order->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="text-center">
                                <button onclick="return confirm('Bạn có muốn hủy đơn hàng, nếu hủy bạn sẽ không thể đặt lại.')"
                                    class="btn-theme">Hủy đơn hàng</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
            <div class="col-5">
                <div class="mt-5">
                    <h5 class="text-uppercase">Chi tiết đơn hàng</h5>
                    <div class="table-reponsive">
                        <table class="table">
                            <tr>
                                <th>
                                    <div>
                                        <span>Mã đơn hàng:</span>
                                    </div>
                                    <div class="mb-4">
                                        <span>Ngày đặt hàng:</span>
                                    </div>
                                </th>
                                <td class="text-end">
                                    <div>
                                        <span class="fw-bold">{{ $order->order_code }}</span>
                                    </div>
                                    @php
                                        $day = mb_strtoupper($order->created_at->locale('vi')->translatedFormat('l'));
                                    @endphp
                                    <div>
                                        <span>{{ $day}}, {{ $order->created_at->translatedFormat('d \t\h\g m, Y') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-bottom-0">
                                    <div class="mt-4">
                                        <h5 class="text-uppercase">Giao hàng</h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-bottom-0">
                                    <div>
                                        <span class="fw-bold">Hãng vận chuyển</span>
                                    </div>
                                    <div>
                                        <span>Ninja Van</span>
                                    </div>
                                </td>
                                <td class="text-end border-bottom-0">
                                    <div></div>
                                    <span><i class="fa fa-truck fa-lg" aria-hidden="true"></i></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold">Địa chỉ giao hàng</span>
                                    </div>
                                    <div class="mb-4 mt-3">
                                        <span class="d-block">{{ $order->fullname }}</span>
                                        <span class="d-block">{{ $order->address }}</span>
                                        <span class="d-block">{{ $order->phone_number }}</span>
                                        <span class="d-block">{{ $order->email }}</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-bottom-0">
                                    <div class="mt-4">
                                        <h5 class="text-uppercase">Phương thức</h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="mb-4">
                                        <span class="small">{{ $payment_method[$order->payment_method] }}</span>
                                    </div>
                                    <div class="mb-4">
                                        <span
                                            class="small fw-bold {{ $payment_status[$order->payment_status]['class'] }}">{{ $payment_status[$order->payment_status]['value'] }}</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span>
                                        @if ($order->payment_method == 'COD')
                                            <i class="fa fa-money fa-lg" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-credit-card fa-lg" aria-hidden="true"></i>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-bottom-0">
                                    <div class="mt-4">
                                        <h5>TỔNG</h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <span>{{ $order->orderItems->sum('quantity') }} mặt hàng</span>
                                    </div>
                                    <div>
                                        <span>Giảm giá</span>
                                    </div>
                                    <div>
                                        <span>Giao hàng:</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Tổng:</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div>
                                        <span>{{ number_format($order->orderItems->sum(fn($item) => $item->quantity * $item->unit_price), 0, '.', '.') }}đ</span>
                                    </div>
                                    <div>
                                        <span>{{ number_format($order->discount_amount, 0, '.', '.') }}đ</span>
                                    </div>
                                    <div>
                                        <span>{{ number_format($order->shipping, 0, '.', '.') }}đ</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">{{ number_format($order->total, 0, '.', '.') }}đ</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('administrator/js/order.js') }}"></script>
@endsection