<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCancellation;
use App\Models\Reason;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReasonController extends Controller
{
    public function cancel(Request $request)
    {
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $today = Carbon::now();
        $checkCancel = OrderCancellation::whereDate('created_at', $today)->where('user_id', $order->user_id)->count();
        if ($checkCancel >= 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chỉ được hủy đơn 2 lần trong ngày.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        $reason = Reason::where('order_id', $order->id)->where('type', 'cancel')->exists();

        if ($order->status != 'unconfirmed') {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($reason == true) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng đã gửi yêu cầu hủy trước đó.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $data['type'] = 'cancel';
        Reason::create($data);
        OrderCancellation::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Gửi yêu cầu thành công.'
        ], Response::HTTP_OK);
    }

    public function returned(Request $request)
    {
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $reason = Reason::where('order_id', $order->id)->where('type', 'return')->exists();

        if ($order->status != 'delivered') {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($reason == true) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng đã gửi yêu cầu trả hàng trước đó.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $data['type'] = 'return';
        Reason::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Gửi yêu cầu thành công.'
        ], Response::HTTP_OK);
    }
}
