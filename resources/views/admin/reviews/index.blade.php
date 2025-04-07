@extends('admin.layout.master')

@section('content')
<h2>Danh sách đánh giá</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<form action="{{ route('admin-review.index') }}" method="GET" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="text" name="order_code" class="form-control" placeholder="Tìm theo mã đơn hàng..." value="{{ request('order_code') }}">
    </div>
    <div class="col-md-4">
        <input type="date" name="review_date" class="form-control" value="{{ request('review_date') }}">
    </div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        <a href="{{ route('admin-review.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Sản phẩm</th>
            <th>Người dùng</th>
            <th>Bình luận</th>
            <th>Xếp hạng</th>
            <th>Ngày đánh giá</th> <!-- Cột mới -->
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
            <td>{{ $review->order->order_code ?? 'N/A' }}</td>
            <td>{{ $review->product->name ?? 'N/A' }}</td>
            <td>{{ $review->user->name ?? 'N/A' }}</td>
            <td class="comment-column">{{ $review->comment }}</td>
            <td>{{ $review->rating }}/5</td>
            <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <span class="badge {{ $review->status ?  'bg-success' : 'bg-danger'}}">
                    {{ $review->status ? 'Hiển thị' :  'Đã ẩn' }}
                </span>
            </td>
            <td>
                <form action="{{ route('admin-review.hide', $review->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-sm {{ $review->status ? 'btn-warning' : 'btn-success'}}">
                        {{ $review->status ?  'Ẩn' : 'Hiển thị'}}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<style>
.comment-column {
    max-width: 300px;
    max-height: 100px;
    overflow-y: auto;
    word-wrap: break-word;
    white-space: normal;
    padding-right: 5px;
    scrollbar-width: thin;
    scrollbar-color: #ccc transparent;
}

</style>

{{ $reviews->links() }} <!-- Phân trang -->
@endsection
