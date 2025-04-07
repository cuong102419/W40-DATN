<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $query = Product::query();
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = (int) $request->min_price;
            $maxPrice = (int) $request->max_price;

            $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereRaw('(product_variants.price - (product_variants.price * products.discount / 100)) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            });
        }

        $products = $query->whereHas('variants')->latest('id')->paginate(10);
        return view('client.product.index', compact('products', 'categories', 'brands'));
    }
    public function detail($id)
    {
        $product = Product::with('category', 'brand', 'imageLists')->find($id);
        $nextProduct = Product::where('id', '>', $id)->orderBy('id', 'asc')->first();

        if (!$product) {
            return abort(404);
        }

        $user = Auth::user();
        $order = null;
        $variant = null;

        if ($user) {
            $order = Order::where('user_id', $user->id)
                ->where('status', 'completed')
                ->whereHas('orderItems', function ($query) use ($id) {
                    $query->whereHas('productVariant', function ($subQuery) use ($id) {
                        $subQuery->where('product_id', $id);
                    });
                })
                ->with('orderItems.productVariant')
                ->latest()
                ->first();

            if ($order) {
                // Lấy variant đầu tiên liên quan đến sản phẩm
                $variant = $order->orderItems->firstWhere(function ($item) use ($id) {
                    return $item->productVariant->product_id == $id;
                })?->productVariant;
            }
        }

        $hasPurchased = $order !== null;

        $reviews = Review::where('product_id', $id)
            ->where('status', true)
            ->with(['user', 'variant']) // Load thêm variant để view hiển thị size/màu
            ->latest()
            ->paginate(5);

        $products = Product::with('category', 'brand', 'imageLists')->get();

        $product->increment('view');

        return view('client.product.detail', compact(
            'product',
            'products',
            'reviews',
            'order',
            'variant',
            'hasPurchased'
        ));
    }


    public function product($id)
    {
        $product = Product::with('variants')->find($id);
        return view('product-detail', compact('product'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categories = Category::all();
        $brands = Brand::all();

        if ($keyword) {
            $products = Product::where('name', 'LIKE', "%$keyword%")->get();
        } else {
            $products = Product::all();
        }

        return view('client.product.index', compact('products', 'categories', 'brands'));
    }
}
