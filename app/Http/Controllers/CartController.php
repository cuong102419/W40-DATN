<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;


class CartController extends Controller
{
    public function index() {

        $cart = Cart::getContent();
        //dd($cart);
         // Lấy toàn bộ sản phẩm trong giỏ hàng
        return view('client.cart.index', compact('cart'));
    
    }
    

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
{
    //dd($request->all());
    

    $cart = session()->get('cart', []);

    // Thêm sản phẩm vào giỏ hàng
    $cart[$request->id] = [
        "name" => $request->name,
        "price" => $request->price ?? 0,
        "quantity" => ($cart[$request->id]['quantity'] ?? 0) + 1,
        "image" => $request->image
    ];

    session()->put('cart', $cart);

    // 🔥 TRẢ VỀ GIAO DIỆN
    return view('client.cart.index', compact('cart'));
}

}