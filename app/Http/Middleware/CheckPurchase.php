<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Order;

class CheckPurchase
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $hasPurchased = false;

        if ($user) {
            $productId = $request->route('product'); // Đảm bảo route nhận đúng ID
            $hasPurchased = Order::where('user_id', $user->id)
                ->whereHas('orderItems', function ($query) use ($productId) {
                    $query->where('product_variant_id', $productId);
                })
                ->exists();
        }

        // Debug xem middleware có chạy không
        // dd($hasPurchased);

        View::share('hasPurchased', $hasPurchased);

        return $next($request);
    }
}

