<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::whereHas('variants')->where('featured', true)->latest('id')->paginate(10);
        $sellWell = Product::whereHas('variants')->withSum('variants as sale_count', 'sales_count')->orderByDesc('sale_count')->get();

        return view('client.home.home', compact('products', 'sellWell'));
    }
}
