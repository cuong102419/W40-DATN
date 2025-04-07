<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Review;

class CheckPurchase
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $hasPurchased = false;

        if ($user) {
            $productId = $request->route('product_id') ?? $request->route('product');

            if ($productId) {
                // Đếm số lượng đơn hàng đã mua sản phẩm này
                $orders = Order::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereHas('orderItems', function ($query) use ($productId) {
                        $query->whereHas('productVariant', function ($subQuery) use ($productId) {
                            $subQuery->where('product_id', $productId);
                        });
                    })
                    ->pluck('id'); // Lấy ra danh sách order_id

                $totalPurchases = $orders->count();

                // Đếm số lần đã đánh giá sản phẩm này trong các đơn hàng
                $totalReviews = Review::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->whereIn('order_id', $orders)
                    ->count();

                $hasPurchased = $totalReviews < $totalPurchases;
            }
        }

        View::share('hasPurchased', $hasPurchased);

        return $next($request);
    }
}
