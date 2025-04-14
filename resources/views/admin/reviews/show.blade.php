@extends('admin.layout.master')

@section('content')
    <h2>Chi tiết đánh giá</h2>

    <div class="card">
        <div class="card-body">
            <h4><strong>Mã đơn hàng:</strong> {{ $review->order->order_code ?? 'N/A' }}</h4>
            <p><strong>Sản phẩm:</strong> {{ $review->product->name ?? 'N/A' }}</p>
            @if($review->variant)
                <p><strong>Size:</strong> {{ $review->variant->size }}</p>
                <p><strong>Màu:</strong>
                    <span style="width: 20px; height: 20px; background-color: {{ $review->variant->color }}; display: inline-block; border-radius: 50%; border: 1px solid #ccc;"></span>
                </p>
            @endif
            <p><strong>Người dùng:</strong> {{ $review->user->name ?? 'N/A' }} - {{ $review->user->email ?? '' }}</p>
            
            <p>
                <strong>Xếp hạng:</strong>
                @for ($i = 1; $i <= 5; $i++)
                    <span class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}" style="color: orange;"></span>
                @endfor
            </p>

            <p><strong>Tiêu đề:</strong> {{ $review->title }}</p>
            <p><strong>Nội dung:</strong> {{ $review->comment }}</p>

            

            <p><strong>Ngày đánh giá:</strong> {{ $review->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('admin-review.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
@endsection
