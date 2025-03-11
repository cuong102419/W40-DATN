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
        try {
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
            $product = Product::find($productVariant['product_id']);


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
                    'product_id' => $productVariant->product_id,
                    'image' => $product->imageLists->first()->image_url,
                    'name' => $product->name,
                    'color' => $data['color'],
                    'size' => $data['size'],
                    'quantity' => $data['quantity'],
                    'price' => $productVariant->price
                ];
            }
            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm vào giỏ hàng thành công!',
                'cart' => session()->get('cart')
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thêm vào giỏ hàng thất bại, hãy chọn kích cỡ và màu sắc!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy()
    {
        session()->forget('cart');

        return redirect()->back()->with('success', 'Xóa giỏ hàng thành công!');
    }

    public function delete($id)
    {
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
            if ($quantity <= 0) {
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
