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
            $variantId = $request->input('product_variant_id');
            $orderId = $request->input('order_id');

            if ($variantId && $orderId) {
                // Kiểm tra đơn hàng thuộc về user và có chứa variant này
                $order = Order::where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereHas('orderItems', function ($query) use ($variantId) {
                        $query->where('product_variant_id', $variantId);
                    })
                    ->first();

                if ($order) {
                    // Kiểm tra đã review chưa
                    $hasReviewed = Review::where('user_id', $user->id)
                        ->where('order_id', $orderId)
                        ->where('product_variant_id', $variantId)
                        ->exists();

                    $hasPurchased = !$hasReviewed;
                }
            }
        }

        View::share('hasPurchased', $hasPurchased);

        return $next($request);
    }

}







