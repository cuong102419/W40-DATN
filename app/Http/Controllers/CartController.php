<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index()
    {
        return view('client.cart.index');
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $productVariant = ProductVariant::where('product_id', $product->id)
            ->where('color', $request->color)
            ->where('size', $request->size)
            ->first();
        $product = Product::find($productVariant['product_id']);
        $data = $request->validate([
            'color' => ['required'],
            'size' => ['required'],
            'quantity' => ['required', 'min:1']
        ]);

        $productVariant = ProductVariant::where('product_id', $product->id)
            ->where('color', $data['color'])
            ->where('size', $data['size'])
            ->first();

        $productIndex = null;
        foreach ($cart as $index => $item) {
            if ($item['id'] == $productVariant->id) {
                $productIndex = $index;
                break;
            }
        }

        if ($productIndex !== null) {
            $cart[$productIndex]['quantity'] += $data['quantity'];
        } else {
            $cart[] = [
                'id' => $productVariant->id,
                'product_id'=> $productVariant->product_id,
                'image' => $product->imageLists->first()->image_url,
                'name' => $product->name,
                'color' => $data['color'],
                'size' => $data['size'],
                'quantity' => $data['quantity'],
                'price' => $productVariant->price
            ];
        }
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công!');
    }

    public function destroy()
    {
        session()->forget('cart');

        return redirect()->back()->with('success', 'Xóa giỏ hàng thành công!');
    }

    public function delete($id) {
        $cart = session()->get('cart', []);

        $cart = array_values(array_filter($cart, function ($item) use ($id) {
            return $item['id'] != $id;
        }));

        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function update(Request $request)
    {
       $data = $request->quantity;
       $cart = session()->get('cart', []);
       
        foreach ($data as $id => $quantity) {
            if($quantity <= 0) {
                return redirect()->back()->with('error', 'Số lượng không hợp lệ!');
            }

            foreach ($cart as $index => $item) {
                if ($item['id'] == $id) {
                    $cart[$index]['quantity'] = $quantity;
                    break;
                }
            }
        }
        
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }
}
