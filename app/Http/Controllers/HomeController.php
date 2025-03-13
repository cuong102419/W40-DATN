<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index() {
        $products = Product::whereHas('variants')->where('featured', true)->latest('id')->paginate(10);
        return view('client.home.home', compact('products'));
    }
}
