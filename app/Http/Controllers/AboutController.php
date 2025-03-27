<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    //
    public function index()
    {
        $reviews = Review::latest()->take(3)->get(); // Lấy 3 đánh giá mới nhất
        return view('client.about.index', compact('reviews'));
    }
}
