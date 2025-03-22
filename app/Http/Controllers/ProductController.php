<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

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
        $reviews = \App\Models\Review::where('product_id', $id)->latest()->paginate(5);
        $products = Product::with('category', 'brand', 'imageLists')->get();
        $product->increment('view');
        // dd($reviews);
        return view('client.product.detail', compact('product', 'products','reviews'));
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
