<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    // Danh sách tất cả các đánh giá
    public function index() {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    // Ẩn hoặc hiện đánh giá
    public function hide($id)
    {
        $review = Review::findOrFail($id);
        $review->status =  !$review->status; // Đảo ngược trạng thái
        $review->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
