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
            <div class="w-75 mt-5">
                @foreach ($orders as $order)
                    <a href="{{ route('order.detail', $order->id) }}">
                        <div class="border p-3">
                            <h5 class="fw-bold">
                                {{ $order->created_at->format('d \T\H\G m, Y') }} | <span class="text-dark fw-bold">{{ number_format($order->total, 0, '.', '.') }}đ</span>
                            </h5>
                            <p class="mb-2">Mã đơn hàng: <span class="fw-semibold">{{ $order->id }}</span></p>
                            <div class="d-flex align-items-center">
                                @foreach ($order->orderItems as $item)
                                    <img src="{{ Storage::url($item->product_variant->product->imageLists->first()->image_url) }}" alt="Ảnh sản phẩm" class="img-fluid ms-2" width="100">
                                @endforeach
                            </div>
                        </div>
                    </a>
                @endforeach
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection