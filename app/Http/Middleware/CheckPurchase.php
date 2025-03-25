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
        // dd('Middleware running...');

        $user = Auth::user();
        $hasPurchased = false;

        if ($user) {
            // Lấy product_id từ route
            // dd($request->route('product'));
            // dd($request->route()->parameters());

            $productId = $request->route('product_id') ?? $request->route('product');
            // dd($productId);

            if ($productId) {
                $order = Order::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereHas('orderItems', function ($query) use ($productId) {
                        $query->whereHas('productVariant', function ($subQuery) use ($productId) {
                            $subQuery->where('product_id', $productId);
                            
                        });
                    })
                    
                    ->latest('created_at') // Lấy lần mua gần nhất
                    ->first();
            
                $hasPurchased = $order ? true : false;
                // dd($hasPurchased);
                if ($hasPurchased) {
                    // Kiểm tra đã đánh giá chưa cho lần mua gần nhất
                    $alreadyReviewed = Review::where('user_id', $user->id)
                        ->where('product_id', $productId)
                        ->where('created_at', '>=', $order->created_at) // Đánh giá sau khi mua
                        ->exists();
            
                    if ($alreadyReviewed) {
                        $hasPurchased = false;
                    }
                }
            }
        }
        // dd($hasPurchased);
       

        View::share('hasPurchased', $hasPurchased);

        return $next($request);
    }

























































































































































    
}
