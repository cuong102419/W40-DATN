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
        $cart = session()->get('cart', []);
        $productId = collect($cart)->pluck('product_id')->toArray();
        $variantId = collect($cart)->pluck('id')->toArray();
        $products = Product::whereIn('id', $productId)->get();
        $variants = ProductVariant::whereIn('id', $variantId)->get();

        return view('client.cart.index', compact('products', 'variants'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
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
                'quantity' => $data['quantity'],
                'price' => $productVariant->price
            ];
        }
        session()->put('cart', $cart);

        return redirect()->back();
    }

    public function destroy()
    {
        session()->forget('cart');

        return redirect()->back();
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
            foreach ($cart as $index => $item) {
                if ($item['id'] == $id) {
                    $cart[$index]['quantity'] = $quantity;
                    break;
                }
            }
        }
        
        session()->put('cart', $cart);

        return redirect()->back();
    }
}
