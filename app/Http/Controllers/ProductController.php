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
    
            // Lấy order đầu tiên để dùng chung cho hidden input nếu cần
            $order = $orderItems->first()?->order;
    
            // Lấy variant đầu tiên để hiển thị mặc định nếu muốn
            $filteredOrderItems = $orderItems->filter(function ($item) use ($user) {
                return !Review::where('user_id', $user->id)
                    ->where('order_id', $item->order_id)
                    ->where('product_variant_id', $item->product_variant_id)
                    ->exists();
            });
            
            $orderItems = $filteredOrderItems; // Gán lại danh sách đã lọc
            $order = $filteredOrderItems->first()?->order;
            $variant = $filteredOrderItems->first()?->productVariant;
            
        }
    
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
