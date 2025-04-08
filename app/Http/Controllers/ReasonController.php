<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Reason;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReasonController extends Controller
{
    public function cancel(Request $request) {
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $reason = Reason::where('order_id', $order->id)->where('type', 'cancel')->exists();
        
        if ($order->status != 'unconfirmed') {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        if($reason == true) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng đã gửi yêu cầu hủy trước đó.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $data['type'] = 'cancel';
        Reason::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Gửi yêu cầu thành công.'
        ], Response::HTTP_OK);
        
    }
}
