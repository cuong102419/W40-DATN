<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;

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
        // Sắp xếp (sort by)
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('sales_count', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('reviews', 'rating')
                        ->orderBy('reviews_avg_rating', 'desc');
                    break;
                case 'newness':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->latest('id');
            }
        } else {
            $query->latest('id'); // Default sort
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
        $orderItems = collect(); // Khởi tạo rỗng
        $hasPurchased = false;

        if ($user) {
            // Lấy tất cả các OrderItem mà user đã mua có chứa product này
            $orderItems = OrderItem::with('productVariant')
                ->whereHas('order', function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->where('status', 'completed');
                })
                ->whereHas('productVariant', function ($q) use ($id) {
                    $q->where('product_id', $id);
                })
                ->get();

            $hasPurchased = $orderItems->isNotEmpty();

            // Lọc các orderItems mà user chưa review biến thể đó (bỏ kiểm tra theo order_id)
            $filteredOrderItems = $orderItems->filter(function ($item) use ($user) {
                return !Review::where('user_id', $user->id)
                    ->where('product_variant_id', $item->product_variant_id)
                    ->exists();
            });

            $orderItems = $filteredOrderItems; // Gán lại danh sách đã lọc
            $order = $filteredOrderItems->first()?->order;
            $variant = $filteredOrderItems->first()?->productVariant;
        }
        $allReviews = Review::where('product_id', $id)
            ->where('status', true)
            ->get();

        $averageRating = round($allReviews->avg('rating'), 1);
        $totalReviews = $allReviews->count();
        $reviews = Review::where('product_id', $id)

            ->where('status', true)
            ->with(['user', 'variant'])
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
            'orderItems', //Truyền biến này vào view
            'hasPurchased',
            'averageRating',
            'totalReviews'
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





















