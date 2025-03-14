<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $subTotal = 0;
        $cart = session()->get('cart', []);
        foreach ($cart as $item) {
            $subTotal += $item['quantity'] * $item['price'];
        }
        return view('client.order.index', compact('subTotal'));
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
            'payment_method' => ['required']
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

        $data['total'] = 0;
        foreach ($cart as $item) {
            $data['total'] += $item['quantity'] * $item['price'];
        }

        if($cart) {
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

                session()->forget('cart');

                return redirect()->route('order.detail', $order->id)->with('success', 'Đặt hàng thành công.');
    
            }
        }
    }

    public function detail(Order $order) {
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD)',
            'MOMO' => 'Ví điện tử MOMO',
            'ATM' => 'Thẻ ngân hàng.',
        ];
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        return view('client.order.detail', compact('order', 'payment_method', 'orderItems'));
    }
}
