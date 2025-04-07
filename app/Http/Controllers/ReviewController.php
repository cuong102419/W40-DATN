<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function store(Request $request)
     {
         $request->validate([
             'product_id' => 'required|exists:products,id',
             'order_id' => 'required|exists:orders,id',
             'rating' => 'required|integer|min:1|max:5',
             'title' => 'required|string|max:255',
             'comment' => 'required|string|max:1500',
         ]);
     
         $user = Auth::user();
     
         // Kiểm tra đơn hàng có thuộc về user và chứa sản phẩm đó không
         $order = Order::where('id', $request->order_id)
             ->where('user_id', $user->id)
             ->where('status', 'completed')
             ->whereHas('orderItems', function ($query) use ($request) {
                 $query->whereHas('productVariant', function ($q) use ($request) {
                     $q->where('product_id', $request->product_id);
                 });
             })
             ->first();
     
         if (!$order) {
             return back()->with('error', 'Bạn không thể đánh giá sản phẩm này cho đơn hàng đã chọn.');
         }
     
         // Kiểm tra đã đánh giá đơn hàng này chưa
         $alreadyReviewed = Review::where('user_id', $user->id)
             ->where('product_id', $request->product_id)
             ->where('order_id', $request->order_id)
             ->exists();
     
         if ($alreadyReviewed) {
             return back()->with('error', 'Bạn đã đánh giá sản phẩm này cho đơn hàng này rồi.');
         }
     
         // Tạo đánh giá
         Review::create([
             'user_id' => $user->id,
             'product_id' => $request->product_id,
             'order_id' => $request->order_id,
             'rating' => $request->rating,
             'title' => $request->title,
             'comment' => $request->comment,
         ]);
     
         return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
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
