<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('admin.product.index');
    }

    public function create() {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.product.create', compact('brands', 'categories'));
    }

    public function store(Request $request) {
        dd($request);
    }

    public function detail() {
        return view('admin.product.detail');
    }
}
