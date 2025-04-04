@extends('admin.layout.master')

@section('content')
<h2>Danh sách đánh giá</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Mã đơn hàng</th>  <!-- Thêm cột mã đơn hàng -->
            <th>Sản phẩm</th>
            <th>Người dùng</th>
            <th>Bình luận</th>
            <th>Xếp hạng</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
            <!-- Hiển thị mã đơn hàng -->
            <td>{{ $review->order->order_code ?? 'N/A' }}</td>  <!-- Lấy mã đơn hàng từ quan hệ Order -->
            <td>{{ $review->product->name ?? 'N/A' }}</td>
            <td>{{ $review->user->name ?? 'N/A' }}</td>
            <td>{{ $review->comment }}</td>
            <td>{{ $review->rating }}/5</td>
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

{{ $reviews->links() }} <!-- Phân trang -->
@endsection
