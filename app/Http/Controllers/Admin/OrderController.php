<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest('id')->paginate(10);
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD)',
            'VNPAY' => "Thanh toán qua VNPay",
            'MOMO' => 'Ví điện tử MOMO'
        ];
        $payment_status = [
            'unpaid' => ['value' => 'Chưa thanh toán.', 'class' => 'text-secondary'],
            'paid' => ['value' => 'Đã thanh toán.', 'class' => 'text-primary'],
            'refunded' => ['value' => 'Hoàn tiền.', 'class' => 'text-warning'],
            'cancel' => ['value' => 'Hủy thanh toán.', 'class' => 'text-danger']
        ];
        $status = [
            'unconfirmed' => ['value' => 'Chờ xác nhận.', 'class' => 'text-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận.', 'class' => 'text-primary'],
            'shipping' => ['value' => 'Đang giao hàng.', 'class' => 'text-warning'],
            'delivered' => ['value' => 'Đã giao hàng.', 'class' => 'text-primary'],
            'completed' => ['value' => 'Hoàn thành.', 'class' => 'text-success'],
            'canceled' => ['value' => 'Hủy đơn.', 'class' => 'text-danger'],
        ];


        return view('admin.order.index', compact('orders', 'payment_method', 'payment_status', 'status'));
    }

    public function detail(Order $order)
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $requestOrder = Reason::where('order_id', $order->id)->first();
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD).',
            'VNPAY' => "Thanh toán qua VNPay.",
            'MOMO' => 'Ví điện tử MOMO.'
        ];
        $payment_status = [
            'unpaid' => ['value' => 'Chưa thanh toán.', 'class' => 'text-primary'],
            'paid' => ['value' => 'Đã thanh toán.', 'class' => 'text-success'],
            'refunded' => ['value' => 'Hoàn tiền.', 'class' => 'text-warning'],
            'cancel' => ['value' => 'Hủy thanh toán.', 'class' => 'text-danger']
        ];
        $status = [
            'unconfirmed' => ['value' => 'Chờ xác nhận.', 'class' => 'text-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận.', 'class' => 'text-primary'],
            'shipping' => ['value' => 'Đang giao hàng.', 'class' => 'text-warning'],
            'delivered' => ['value' => 'Đã giao hàng.', 'class' => 'text-primary'],
            'completed' => ['value' => 'Hoàn thành.', 'class' => 'text-success'],
            'canceled' => ['value' => 'Hủy đơn.', 'class' => 'text-danger'],
        ];
        $day = ucfirst(mb_strtolower($order->created_at->locale('vi')->translatedFormat('l')));;

        return view('admin.order.detail', compact('orderItems', 'order', 'payment_status', 'payment_method', 'status', 'day', 'requestOrder'));
    }

    public function updatePayment(Request $request, Order $order)
    {
        if ($request['payment_status']) {
            $order['payment_status'] = $request['payment_status'];
            $order->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không có trạng thái nào được chọn.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateInfo(Request $request, Order $order)
    {
        $data = $request->validate([
            'fullname' => ['required', 'min:4'],
            'phone_number' => ['required', 'phone:VN'],
            'email' => ['required', 'email'],
            'address' => ['required', 'min:4'],
            'note' => ['nullable']
        ], [
            'fullname.required' => 'Không được để trống.',
            'fullname.min' => 'Tối thiểu 4 ký tự.',
            'phone_number.required' => 'Không được để trống.',
            'phone_number.phone' => 'Số không hợp lệ.',
            'email.required' => 'Không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'address.required' => 'Không được để trống.',
            'address.min' => 'Tối thiểu 4 ký tự.',
        ]);

        $order->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }

    public function status(Request $request, Order $order)
    {
        if ($request->input('action') == 'confirmed') {
            foreach ($order->orderItems as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if (!$variant) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sản phẩm không tồn tại.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                if ($item->quantity > $variant->quantity) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Số lượng hàng trong kho không đủ.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            foreach ($order->orderItems as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                $variant->quantity -= $item->quantity;
                $variant->save();
                Product::where('id', $variant->product_id)->increment('sales_count');
            }

            $order->status = 'confirmed';
            $order->save();

            $reason = Reason::where('order_id', $order->id)->first();

            if ($reason) {
                $reason->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

        if ($request->input('action') == 'shipping') {
            $order->status = 'shipping';
            $order->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

        if ($request->input('action') == 'delivered') {
            $order->update([
                'status' => 'delivered',
                'payment_status' => 'paid'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

        if ($request->input('action') == 'completed') {
            $order->status = 'completed';
            $order->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }
    }

    public function cancel(Request $request, Order $order)
    {
        $adminId = Auth::user()->id;

        $order->update([
            'admin_id' => $adminId,
            'status' => 'canceled',
            'reason' => $request->reason
        ]);

        if($order->payment_method == 'COD') {
            $order->update([
                'payment_status' => 'cancel'
            ]);
        }

        $reason = Reason::where('order_id', $order->id)->first();

        if($reason) {
            $reason->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }
}
