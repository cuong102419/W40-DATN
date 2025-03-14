<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        return view('client.wishlist.index');
    }

    public function add(Request $request, Product $product)
    {
        try {
            $wishlist = session()->get('wishlist', []);
            $data = $request->validate([
                'color' => ['required'],
                'size' => ['required']
            ]);

            $productVariant = ProductVariant::where('product_id', $product->id)
                ->where('color', $data['color'])
                ->where('size', $data['size'])
                ->first();

            if (!$productVariant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không tìm thấy sản phẩm với màu sắc và kích cỡ đã chọn!'
                ], Response::HTTP_NOT_FOUND);
            }

            $product = Product::find($productVariant['product_id']);
            $discount = $product->discount;
            $price = $productVariant->price * (1 - $discount / 100);

            // Kiểm tra sản phẩm đã có trong wishlist chưa
            $productExists = collect($wishlist)->firstWhere('id', $productVariant->id);

            if (!$productExists) {
                $wishlist[] = [
                    'id' => $productVariant->id,
                    'product_id' => $productVariant->product_id ?? null, // Kiểm tra có tồn tại không
                    'image' => $product->imageLists->first()->image_url ?? asset('default-image.jpg'), // Tránh lỗi ảnh null
                    'name' => $product->name,
                    'color' => $data['color'] ?? null,
                    'size' => $data['size'] ?? null,
                    'price' => $price
                ];
            }

            session()->put('wishlist', $wishlist);

            return response()->json([
                'status' => 'success',
                'message' => 'Đã thêm vào danh sách yêu thích!',
                'wishlist' => session()->get('wishlist')
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thêm vào danh sách yêu thích thất bại!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
