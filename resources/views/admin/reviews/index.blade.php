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
    <div class="col-md-3"> 
        <input type="date" name="review_date" class="form-control" value="{{ request('review_date') }}">
    </div>
    <div class="col-md-2"> 
        <select name="rating" class="form-select">
            <option value="">Tất cả số sao</option>
            @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                    {{ $i }} sao
                </option>
            @endfor
        </select>
    </div>
    
    <div class="col-md-1"  style="width: 100px;"> 
        <button type="submit" class="btn btn-primary btn-sm w-100">Tìm kiếm</button>
    </div>
    <div class="col-md-1"> 
        <a href="{{ route('admin-review.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
    </div>
</form>


<table class="table table-striped">
    <thead>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Sản phẩm</th>
            <th>Người dùng</th>
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
            <td><p>
                <strong></strong>
                @for ($i = 1; $i <= 5; $i++)
                    <span class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}" style="color: orange;"></span>
                @endfor
            </p></td>
            <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <span class="badge {{ $review->status ?  'bg-success' : 'bg-danger'}}">
                    {{ $review->status ? 'Hiển thị' :  'Đã ẩn' }}
                </span>
            </td>
            <td>
                <form action="{{ route('admin-review.hide', $review->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-sm {{ $review->status ? 'btn-warning' : 'btn-success'}}">
                        {{ $review->status ?  'Ẩn' : 'Hiển thị'}}
                    </button>
                </form>
            
                <a href="{{ route('admin-review.show', $review->id) }}" class="btn btn-sm btn-primary">
                    Chi tiết
                </a>
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
