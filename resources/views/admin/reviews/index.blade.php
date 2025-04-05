@extends('admin.layout.master')

@section('content')
<h2>Danh sách đánh giá</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

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
    max-height: 100px; /* Giới hạn chiều cao */
    overflow-y: auto; /* Hiển thị thanh cuộn khi nội dung quá dài */
    word-wrap: break-word;
    white-space: normal;
    display: block; /* Đảm bảo phần tử có thể scroll được */
}
</style>

{{ $reviews->links() }} <!-- Phân trang -->
@endsection
