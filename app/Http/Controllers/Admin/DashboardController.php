<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $status = [
            'completed' => 'Hoàn thành.',
            'canceled' => 'Hủy đơn.',
        ];
        $todayOrders = Order::where('status', '=', 'completed')->whereDate('created_at', now())->count();
        $totalOrders = Order::where('status', '=', 'completed')->count();
        $todayRevenue = Order::where('status', '=', 'completed')->whereDate('created_at', now())->sum('total');
        $totalRevenue = Order::where('status', '=', 'completed')->sum('total');
        $order = Order::selectRaw('status, COUNT(*) as total')
            ->whereIn('status', ['completed', 'canceled'])
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $orderStatus = [];
        foreach ($order as $index => $value) {
            $orderStatus[$status[$index]] = $value;
        }
        
        $revenueDaily = Order::selectRaw('DATE_FORMAT(created_at, "%d-%m") as date, SUM(total) as total')
            ->where('status', '=', 'completed')
            ->orderBy('date', 'asc')
            ->groupBy('date')
            ->pluck('total', 'date');

        return view('admin.dashboard.index', compact('todayOrders', 'totalOrders', 'todayRevenue', 'totalRevenue', 'orderStatus', 'revenueDaily'));
    }
}
