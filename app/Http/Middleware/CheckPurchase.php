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
            $productVariantId = $request->input('product_variant_id') ?? $request->route('variant');
            // dd([
            //     'user_id' => $user->id,
            //     'product_variant_id' => $productVariantId,
            // ]);
            if ($productVariantId) {
                
                // Đếm số lượng đơn hàng đã mua sản phẩm này
                $orders = Order::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereHas('orderItems', function ($query) use ($productVariantId) {
                        $query->whereHas('product_variant', function ($query) use ($productVariantId) {
                            $query->where('product_variant_id', $productVariantId);
                        });
                    })
                    ->pluck('id'); // Lấy ra danh sách order_id
                    // dd([
                    //     'user_id' => $user->id,
                    //     'product_variant_id' => $productVariantId,
                    //     'order_ids' => $orders,
                    // ]);
                $totalPurchases = $orders->count();
                

                // Đếm số lần đã đánh giá sản phẩm này trong các đơn hàng
                $totalReviews = Review::where('user_id', $user->id)
                    ->where('product_variant_id', $productVariantId)
                    ->whereIn('order_id', $orders)
                    ->count();

                $hasPurchased = $totalReviews < $totalPurchases;
            }
        }

        View::share('hasPurchased', $hasPurchased);

        return $next($request);
    }
}




