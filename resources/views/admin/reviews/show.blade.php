@extends('admin.layout.master')

@section('content')
    <h2 class="mb-4">Chi tiết đánh giá</h2>

    <div class="card">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5><strong>Mã đơn hàng:</strong> {{ $review->order->order_code ?? 'N/A' }}</h4>
                    <p><strong>Sản phẩm:</strong> {{ $review->product->name ?? 'N/A' }}</p>

                    @if ($review->variant)
                        <p><strong>Size:</strong> {{ $review->variant->size }}</p>
                        <p><strong>Màu:</strong>
                            <span
                                style="width: 20px; height: 20px; background-color: {{ $review->variant->color }}; display: inline-block; border-radius: 50%; border: 1px solid #ccc;"></span>
                        </p>
                    @endif
                    <div class="mb-3">
                        <p><strong>Người dùng:</strong> {{ $review->user->name ?? 'N/A' }} <br>
                            <strong>Email:</strong> <span class="text-muted">{{ $review->user->email ?? '' }}</span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <p><strong>Xếp hạng:</strong>
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}" style="color: orange;"></span>
                            @endfor
                        </p>
                    </div>

                    <div class="mb-3">
                        <p><strong>Tiêu đề:</strong> <span class="text-muted">{{ $review->title }}</span></p>
                        <p><strong>Nội dung:</strong> <span class="text-muted">{{ $review->comment }}</span></p>
                    </div>
                    @if ($review->images)
                        <div class="mb-3">
                            <p><strong>Hình ảnh đánh giá:</strong></p>
                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                @foreach (json_decode($review->images) as $image)
                                    <img src="{{ Storage::url($image) }}" alt="Hình ảnh đánh giá"
                                        style="max-width: 150px; border-radius: 5px; border: 1px solid #ccc; cursor: pointer;"
                                        onclick="openImageModal(this.src)">
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div id="imageModal" onclick="closeImageModal()"
                        style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; 
                       background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center;">
                        <img id="modalImage" src="" alt="Zoom ảnh"
                            style="max-width: 90%; max-height: 90%; border-radius: 8px;">
                    </div>
                    <div class="mb-3">
                        <p><strong>Trạng thái:</strong>
                            @if ($review->status)
                                <span class="badge bg-success">Hiển thị</span>
                            @else
                                <span class="badge bg-danger">Đã ẩn</span>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <p><strong>Ngày đánh giá:</strong>
                            <span class="text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                        </p>
                    </div>

                    <a href="{{ route('admin-review.index') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Quay lại
                    </a>
            </div>
        </div>
    @endsection
    <script src="{{ asset('administrator/js/product.detail.js') }}"></script>
