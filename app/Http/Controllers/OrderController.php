<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        $subTotal = 0;
        $voucher = 0;
        $cart = session()->get('cart', []);
        foreach ($cart as $item) {
            $subTotal += $item['quantity'] * $item['price'];
        }
        if(session()->get('voucher')) {
            $voucher = session()->get('voucher')['value'];
        }
        return view('client.order.index', compact('subTotal', 'voucher'));
    }

    public function create(Request $request)
    {
        $cart = session('cart', []);
        $data = $request->validate([
            'fullname' => ['required', 'min:4'],
            'address' => ['required', 'min:4'],
            'phone_number' => ['required', 'phone:VN'],
            'email' => ['required', 'email'],
            'note' => ['nullable'],
            'payment_method' => ['required'],
            'total' => ['required'],
            'discount_amount' => ['required']
        ], [
            'fullname.required' => 'Không được để trống.',
            'fullname.min' => 'Tối thiểu 4 ký tự.',
            'address.required' => 'Không được để trống.',
            'address.min' => 'Tối thiểu 4 ký tự.',
            'phone_number.required' => 'Không được để trống.',
            'phone_number.phone' => 'Số điện thoại không hợp lệ.',
            'email.required' => 'Không được để trống.',
            'email.email' => 'Email không hợp lệ.'
        ]);
        
        if (Auth::check()) {
            $data['user_id'] = Auth::user()->id;
        }

        $voucher = session()->get('voucher');

        if ($cart) {
            if ($data['payment_method'] == 'COD') {
                $order = Order::create($data);

                foreach ($cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item['id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price']
                    ]);

                }

                if ($voucher) {
                    Voucher::where('code', $voucher['code'])->decrement('quantity', 1);
                }

                session()->forget('cart');
                session()->forget('voucher');

                return redirect()->route('order.checkout', $order->id)->with('success', 'Đặt hàng thành công.');
            }
        }
    }


    public function checkout(Order $order) {
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD)',
            'MOMO' => 'Ví điện tử MOMO',
            'ATM' => 'Thẻ ngân hàng.',
        ];
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        return view('client.order.checkout', compact('order', 'payment_method', 'orderItems'));
    }

    public function list() {
        $orders = Order::where('user_id', Auth::user()->id)->latest('id')->paginate(5);
        $status = [
            'unconfirmed' => ['value' => 'Chờ xác nhận.', 'class' => 'text-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận.', 'class' => 'text-primary'],
            'shipping' => ['value' => 'Đang giao hàng.', 'class' => 'text-warning'],
            'delivered' => ['value' => 'Đã giao hàng.', 'class' => 'text-primary'],
            'completed' => ['value' => 'Hoàn thành.', 'class' => 'text-success'],
            'canceled' => ['value' => 'Hủy đơn.', 'class' => 'text-danger'],
        ];
        $orderIds = $orders->pluck('id');

        return view('client.order.list', compact('orders', 'status', 'orderIds'));
    }

    public function detail(Order $order) {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $status = [
            'unconfirmed' => ['value' => 'Chờ xác nhận', 'class' => 'text-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận', 'class' => 'text-primary'],
            'shipping' => ['value' => 'Đang giao hàng', 'class' => 'text-warning'],
            'delivered' => ['value' => 'Đã giao hàng', 'class' => 'text-primary'],
            'completed' => ['value' => 'Hoàn thành', 'class' => 'text-success'],
            'canceled' => ['value' => 'Đã hủy', 'class' => 'text-danger'],
        ];
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD)',
            'MOMO' => 'Ví điện tử MOMO',
            'ATM' => 'Thẻ ngân hàng.',
        ];

        return view('client.order.detail', compact('order', 'orderItems', 'status', 'payment_method'));
    }

    public function cancel(Order $order) {
        try {
            if($order->status != 'unconfirmed') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không thể hủy đơn hàng.'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    
            $order->status = 'canceled';
            $order->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Hủy đơn hàng thành công'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể hủy đơn hàng.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ], [
            'code.required' => 'Vui lòng nhập mã giảm giá.',
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại.');
        }
        if ($voucher->quantity <= 0) {
            return redirect()->back()->with('error', 'Mã giảm giá đã hết số lượng.');
        }
        if ($voucher->expiration_date < now()) {
            return redirect()->back()->with('error', 'Mã giảm giá đã hết hạn.');
        }

        session(['voucher' => [
            'code' => $voucher->code,
            'value' => $voucher->value,
            'product_id' => $voucher->product_id
        ]]);

        return redirect()->back()->with('success', 'Mã giảm giá đã được áp dụng.');
    }
}
