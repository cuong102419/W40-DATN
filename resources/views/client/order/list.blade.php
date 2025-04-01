@extends('client.layout.master')

@section('title')
    Lịch sử mua hàng
@endsection

@section('content')
    <div class="mt-5 mb-5">
        <div>
            <h3 class="text-uppercase text-center">Đơn hàng của bạn</h3>
        </div>
        <div class="row justify-content-center">
            @if ($orders->count() > 0)
                <div class="w-75 mt-5">
                    @foreach ($orders as $order)
                        <a href="{{ route('order.detail', $order->id) }}">
                            <div class="border p-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="fw-bold">
                                            Mã đơn: {{ $order->order_code }} | Thành tiền: <span
                                                class="fw-bold text-danger">{{ number_format($order->total, 0, '.', '.') }}đ</span>
                                        </h6>
                                        <span class="mb-2">Ngày tạo: {{ $order->created_at->format('d \T\h\á\n\g m, Y') }}</span>
                                    </div>
                                    <div>
                                        <span>Phương thức thanh toán</span>
                                        <div>
                                            <span
                                                class="text-dark d-block">{{ $payment_method[$order->payment_method] }}</span>
                                            <span
                                                class="d-block fw-bold text-dark">{{ $payment_status[$order->payment_status] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    @foreach ($order->orderItems->slice(0, 2) as $item)
                                        <div class="d-flex me-3">
                                            <img src="{{ Storage::url($item->product_variant->product->imageLists->first()->image_url) }}"
                                                alt="Ảnh sản phẩm" class="img-fluid ms-2 rounded" width="100">
                                            <div class="ms-2">
                                                <div>
                                                    <small
                                                        class="text-dark fw-bold d-block">{{ $item->product_variant->product->name }}</small>
                                                    <small class="text-dark d-block"><strong>Số lượng:</strong>
                                                        {{ $item->quantity }}</small>
                                                    <small class="text-dark d-block"><strong>Kích cỡ:</strong>
                                                        {{ $item->product_variant->size }}</small>
                                                </div>
                                                <div class="d-flex">
                                                    <div>
                                                        <small class="text-dark fw-bold">Màu sắc:</small>
                                                    </div>
                                                    <div class="rounded-circle border border-secondary shadow mt-2 ms-2"
                                                        style="width: 16px; height: 16px; background-color: {{ $item->product_variant->color }}; display: inline-block;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    @endforeach
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            @else
                <div class="mt-5">
                    <h5 class="text-center">Chưa có đơn hàng nào</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
