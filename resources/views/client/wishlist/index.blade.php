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
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th class="product-remove">&nbsp;</th>
                                <th class="product-thumb">&nbsp;</th>
                                <th class="product-name">Sản phẩm</th>
                                <th class="product-stock-status">Trạng thái</th>
                                <th class="product-price">Giá</th>
                                <th class="product-action">&nbsp;</th>
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
                                    <a href="{{ route('product.detail', $item->product_id ?? 0) }}">
                                        <img src="{{ asset('storage/' . $item->image) }}" width="100" alt="Image">

                                    </a>
                                </td>
                                <td class="product-name">
                                    <div>
                                        <h4 class="fw-bold text-center">
                                            <a href="{{ route('product.detail', $item->product_id ?? 0) }}">
                                                {{ $item->product->name ?? 'Sản phẩm không có tên' }}
                                            </a>
                                        </h4>
                                    </div>
                                </td>
                                <td class="product-stock-status">
                                    <span class="stock">Còn hàng</span>
                                </td>
                                <td class="product-price">
                                    <span class="price text-danger">
                                        <strong>{{ !empty($item->price) ? number_format($item->price, 0, ',', '.') . 'đ' : 'Chưa có giá' }}</strong>
                                    </span>
                                </td>
                                <td class="product-action">
                                    <form id="add-to-cart" action="{{ route('cart.add', ['product' => $item->product_id]) }}" method="POST">

                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <button type="submit" class="btn-cart">Thêm vào giỏ hàng</button>
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
@endsection