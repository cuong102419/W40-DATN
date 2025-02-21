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
    public function product()
    {
        $products = Product::all();
        return view('client.shop', compact('products'));
    }
}
