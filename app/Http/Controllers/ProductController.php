<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index(Request $request) {
        $categories = Category::all();
        $brands = Brand::all();
        $query = Product::query();
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }
        $products = $query->get();
        return view('client.product.index', compact('products', 'categories', 'brands'));
    }
    public function detail() {
        return view('client.product.detail');
    }
    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return view('client.product.detail', ['product' => $product]);
    }
    public function product()
    {
        $products = Product::all();
        return view('client.product.index', compact('products'));
        
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if ($keyword) {
            $products = Product::where('name', 'LIKE', "%$keyword%")->get();
        } else {
            $products = Product::all();
        }

        return view('client.product.index', compact('products'));
    }

}
