<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('client.product.index', compact('products'));
    }
    

    public function detail() {
        return view('client.product.detail');
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('client.product.detail', compact('product'));
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
