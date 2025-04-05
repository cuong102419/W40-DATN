<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', '=', 'user')->count();
        $totalOrders = Order::where('status', '!=', 'canceled')->count();
        $totalSales = Product::sum('sales_count');
        $totalRevenueMonth = Order::where('payment_status', 'paid')->whereMonth('created_at', Carbon::now()->month)->sum('total');
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        $revenueMonth = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as revenue")
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month');

        $order = Order::selectRaw('status, COUNT(*) as total')
            ->whereIn('status', ['completed', 'canceled'])
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $status = [
            'completed' => 'Hoàn thành.',
            'canceled' => 'Hủy đơn.',
        ];

        $orderStatus = [];
        foreach ($order as $index => $value) {
            $orderStatus[$status[$index]] = $value;
        }

        $statusOrder = [
            'unconfirmed' => ['value' => 'Chờ xác nhận', 'class' => 'bg-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận', 'class' => 'bg-primary'],
            'shipping' => ['value' => 'Đang giao hàng', 'class' => 'bg-warning'],
            'delivered' => ['value' => 'Đã giao hàng', 'class' => 'bg-primary'],
            'completed' => ['value' => 'Hoàn thành', 'class' => 'bg-success'],
            'canceled' => ['value' => 'Đã hủy', 'class' => 'bg-danger'],
        ];

        $quickListOrders = Order::orderBy('created_at', 'desc')->take(6)->get();
        $productSale = Product::orderBy('sales_count', 'desc')
            ->limit(5)
            ->get();

        $productMonth = Product::whereHas('variants')->whereHas('imageLists')->latest('id')->limit(5)->get();
        $productView = Product::whereHas('variants')->whereHas('imageLists')->orderBy('view', 'desc')->limit(5)->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalOrders',
            'totalSales',
            'totalRevenueMonth',
            'totalRevenue',
            'revenueMonth',
            'orderStatus',
            'quickListOrders',
            'productMonth',
            'productView',
            'statusOrder',
            'productSale'
        ));
    }
}
