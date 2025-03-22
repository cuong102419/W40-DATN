<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
        $reviews = Review::where('product_id', $productId)->latest()->get();
        dd($reviews);
        return view('client.product.detail', compact('product', 'reviews'));
    }

    public function store(Request $request)
    {
        // dd($request->all()); 
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:1500',
        ]);
        // dd($request); 
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi.');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
