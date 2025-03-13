<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $subTotal = 0;
        $cart = session()->get('cart', []);
        foreach ($cart as $item) {
            $subTotal += $item['quantity'] * $item['price'];
        }
        return view('client.order.index', compact('subTotal'));
    }

    public function create(Request $request) {
        // dd($request);
    }
}
