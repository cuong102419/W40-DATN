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
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return view('client.cart.index', compact( 'total'));
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
            $discount = $product->discount;
            $price = $productVariant->price * (1 - $discount / 100);

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
                    'price' => $price
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
        try {
            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa giỏ hàng thành công!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa giỏ hàng không thành công!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $cart = session()->get('cart', []);

            $cart = array_values(array_filter($cart, function ($item) use ($id) {
                return $item['id'] != $id;
            }));

            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Xóa sản phẩm khỏi giỏ hàng thất bại!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->quantity;
            $cart = session()->get('cart', []);

            foreach ($data as $id => $quantity) {
                if ($quantity <= 0) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Số lượng không hợp lệ.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                foreach ($cart as $index => $item) {
                    if ($item['id'] == $id) {
                        $cart[$index]['quantity'] = $quantity;
                        break;
                    }
                }
            }

            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật giỏ hàng thành công!',
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật giỏ hàng thất bại!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
