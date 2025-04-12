<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Order $order) {
        $histories = OrderHistory::where('order_id', $order->id)->orderByDesc('changed_at')->get();
        
        return view('admin.history-order.index', compact('histories', 'order'));
    }
}
