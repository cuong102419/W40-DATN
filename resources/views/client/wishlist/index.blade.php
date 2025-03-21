@extends('client.layout.master')

@section('title')
Sản phẩm yêu thích
@endsection

@section('content')
<!--== Start Wishlist Area Wrapper ==-->
<section class="shopping-wishlist-area">
    <div class="container">
        @if ($wishlists->isNotEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="shopping-wishlist-table table-responsive">
                    <table class="table text-center wishlist-table">
                        <thead>
                            <tr>


                                <th class="product-remove">&nbsp;</th>
                                <th class="product-thumb">Hình ảnh</th>
                                <th class="product-name">Sản phẩm</th>
                                <th class="product-stock-status">Trạng thái</th>
                                <th class="product-price">Giá</th>

                                <th class="product-action text-center">Hành động</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wishlists as $item)
                            <tr class="cart-wishlist-item">
                                <td class="product-remove">
                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </form>
                                </td>

                                <td class="product-thumb">
                                    <a href="{{ route('product.detail', $item->product->id) }}">
                                        @if ($item->product && $item->product->imageLists->isNotEmpty())
                                            <img src="{{ Storage::url($item->product->imageLists->first()->image_url) }}"
                                                 class="wishlist-img" alt="{{ $item->product->name }}">
                                        @else
                                            <img src="{{ asset('images/default-product.jpg') }}" class="wishlist-img" alt="No Image Available">
                                        @endif
                                    </a>
                                </td>

                                <td class="product-name text-start">
                                    <a href="{{ route('product.detail', $item->product_id ?? 0) }}" class="fw-bold text-dark">
                                        {{ $item->product->name ?? 'Sản phẩm không có tên' }}
                                    </a>
                                </td>

                                <td class="product-stock-status">
                                    @php
                                        // Lấy tổng số lượng của tất cả biến thể (variants)
                                        $totalQuantity = $item->product->variants->sum('quantity');
                                    @endphp
                                
                                    <span class="d-block">Số lượng: {{ $totalQuantity }}</span>
                                
                                    @if ($totalQuantity > 0)
                                        <span class="stock text-success fw-bold">Còn hàng</span>
                                    @else
                                        <span class="stock text-danger fw-bold">Hết hàng</span>
                                    @endif
                                </td>
                                
                                
                                <td class="product-price">
                                    <span class="price text-danger">
                                        <strong>
                                            @if ($item->product->variants->isNotEmpty())
                                            {{ number_format($item->product->variants->min('price'), 0, ',', '.') }} VNĐ
                                        @else
                                            {{ number_format($item->product->price, 0, ',', '.') }} VNĐ
                                        @endif
                                    </strong>
                                    </span>
                                </td>

                                <td class="product-action text-center align-middle">
                                    <form class="add-to-cart" action="{{ route('cart.add', ['product' => $item->product_id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                
                                        {{-- Chọn màu sắc và size mặc định --}}
                                        @if ($item->product->variants->isNotEmpty())
                                            @php
                                                $defaultVariant = $item->product->variants->first();
                                            @endphp
                                            <input type="hidden" name="color" value="{{ $defaultVariant->color }}">
                                            <input type="hidden" name="size" value="{{ $defaultVariant->size }}">
                                        @endif
                                
                                        <input type="hidden" name="quantity" value="1">

                                        <button type="submit" class="btn-cart btn-add-to-cart">Thêm vào giỏ hàng</button>
                                    </form>
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!--== End Wishlist Area Wrapper ==-->



{{-- <style>
    .wishlist-table {
        border-spacing: 0 15px;
    }
    .wishlist-table th, .wishlist-table td {
        padding: 15px;
        vertical-align: middle;
    }
    .wishlist-img {
        width: 120px;
        height: auto;
        border-radius: 8px;
    }
    .btn-cart {
        background-color: #ff4d4d;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease-in-out;
    }
    .btn-cart:hover {
        background-color: #e60000;
    }
</style> --}}
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('submit', '.add-to-cart-form', function(e) {
    e.preventDefault();
    let form = $(this);
    let button = form.find('.btn-add-to-cart');

    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json", // Đảm bảo nhận JSON
        beforeSend: function() {
            button.prop('disabled', true).text('Đang thêm...');
        },
        success: function(response) {
            alert(response.message);
            window.location.href = "{{ route('cart.index') }}"; // Chuyển hướng ngay sau khi thêm
        },
        error: function(xhr) {
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        },
        complete: function() {
            button.prop('disabled', false).text('Thêm vào giỏ hàng');
        }
    });
});


</script>
@endpush
