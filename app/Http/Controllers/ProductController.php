<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('client.product.index');
    }

    public function detail() {
        return view('client.product.detail');
    }
}
