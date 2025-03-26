@extends('client.layout.master')

@section('title')
    Sản phẩm yêu thích
@endsection

@section('content')
    <!--== Start Wishlist Area Wrapper ==-->
    <section class="shopping-wishlist-area">
        <div class="container">
            @if ($wishlists->isNotEmpty())
                <div class="mb-5">
                    <h3 class="text-center">Danh sách yêu thích của bạn</h3>
                </div>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlists as $item)
                                                            <tr class="cart-wishlist-item">
                                                                <td class="product-remove">
                                                                    <form class="remove-wishlist" action="{{ route('wishlist.remove', $item->id) }}" method="POST"
                                                                        onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
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
                                                                                class="wishlist-img" alt="{{ $item->product->name }}" width="100">
                                                                        @else
                                                                            <img src="{{ asset('images/default-product.jpg') }}" class="wishlist-img"
                                                                                alt="No Image Available">
                                                                        @endif
                                                                    </a>
                                                                </td>

                                                                <td class="product-name text-start">
                                                                    <a href="{{ route('product.detail', $item->product_id ?? 0) }}"
                                                                        class="fw-bold text-dark">
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
                                                                        <span class=" text-success fw-bold">Còn hàng</span>
                                                                    @else
                                                                        <span class=" text-danger fw-bold">Hết hàng</span>
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
                                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div>
                    <h4 class="text-center">Không có sản phẩm nào trong danh sách yêu thích của bạn</h4>
                </div>
            @endif
        </div>
    </section>
    <!--== End Wishlist Area Wrapper ==-->
    <script src="{{ asset('client/js/wishlist.js') }}"></script>
@endsection