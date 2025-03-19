<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Yêu cầu đăng nhập
    }

    // 🛒 Hiển thị danh sách Wishlist
    public function index()
{
    
    $wishlists = Wishlist::with('product')->where('user_id', auth()->id())->get();
    return view('client.wishlist.index', compact('wishlists'));
}

    public function add(Request $request, Product $product)
{
    $exists = Wishlist::where('user_id', Auth::id())
        ->where('product_id', $product->id)
        ->exists();

    if ($exists) {
        return redirect()->route('wishlist.index')->with('error', 'Sản phẩm đã có trong danh sách yêu thích!');
    }

    // Lấy biến thể sản phẩm (nếu có)
    $productVariant = ProductVariant::where('product_id', $product->id)->first();

    // Kiểm tra nếu sản phẩm có biến thể thì lấy giá từ biến thể, nếu không lấy giá gốc
    $price = $productVariant ? $productVariant->price : $product->price;

    // Kiểm tra giá trị price
    if (!$price) {
        return redirect()->route('wishlist.index')->with('error', 'Sản phẩm chưa có giá, không thể thêm vào danh sách yêu thích!');
    }

    Wishlist::create([
        'user_id'   => Auth::id(),
        'product_id' => $product->id,
        'price'     => $price,
        'image'     => $product->image ?? asset('default-image.jpg'),
    ]);

    return redirect()->route('wishlist.index')->with('success', 'Đã thêm vào danh sách yêu thích!');
}
public function remove($id)
{
    $wishlist = Wishlist::where('id', $id)->where('user_id', auth()->id())->first();

    if (!$wishlist) {
        return redirect()->route('wishlist.index')->with('error', 'Không tìm thấy sản phẩm!');
    }

    $wishlist->delete();
    return redirect()->route('wishlist.index')->with('success', 'Đã xóa khỏi danh sách yêu thích!');
}

}
