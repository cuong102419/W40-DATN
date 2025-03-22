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
        // dd('Middleware running...');

        $user = Auth::user();
        $hasPurchased = false;

        if ($user) {
            // Lấy product_id từ route
            // dd($request->route('product'));
            $productId = $request->route('product_id') ?? $request->route('product');

       
            if ($productId) {
                // dd(Order::where('user_id', $user->id)->get());
                $hasPurchased = Order::where('user_id', $user->id)
                    ->where('status', 'confirmed') // Chỉ lấy đơn hàng đã hoàn thành
                    ->whereHas('orderItems', function ($query) use ($productId) {
                        $query->where('product_variant_id', $productId);
                    })
                    ->exists();
                
            }
        }

        // dd($hasPurchased);

        View::share('hasPurchased', $hasPurchased);

        return $next($request);
    }
               
















































































































    
}

