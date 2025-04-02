<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
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
        if (session()->get('voucher')) {
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
        $data['address'] = $data['address'] . ', ' . $request['district'] . ', ' . $request['province'];   
         do {
            $rand = preg_replace('/[^A-Za-z]/', '', Str::random(3));
        } while (strlen($rand) < 3);
        $data['order_code'] = 'FS' . Str::upper($rand) . rand(10000, 99999);

        $data['shipping'] = 100000;
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
                $encryptedId = Crypt::encryptString($order->id);

                return redirect()->route('order.checkout', $encryptedId)->with('success', 'Đặt hàng thành công.');
            }
            
            $order = Order::create($data);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price']
                ]);
            }
            if ($data['payment_method'] == 'ATM') {

                return $this->vnpay($order->id, $order->total, $order->order_code);
            }
            if ($data['payment_method'] == 'MOMO') {

                return $this->momo($data, $order->order_code, $order->total, $order->id);
            }
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm nào.');
        }
    }


    public function checkout($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $order = Order::find($id);

            $payment_method = [
                'COD' => 'Thanh toán khi nhận hàng (COD)',
                'MOMO' => 'Ví điện tử MOMO',
                'ATM' => 'Thanh toán qua VNPay.',
            ];
            $orderItems = OrderItem::where('order_id', $order->id)->get();
            return view('client.order.checkout', compact('order', 'payment_method', 'orderItems'));
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function list()
    {
        $orders = Order::where('user_id', Auth::user()->id)->latest('id')->paginate(5);
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD)',
            'ATM' => "Thanh toán qua VNPay",
            'MOMO' => 'Ví điện tử MOMO'  
        ];
        $payment_status = [
            'unpaid' => 'Chưa thanh toán',
            'paid' =>'Đã thanh toán',
            'refunded' =>'Hoàn trả',
            'cancel' =>'Hủy thanh toán',
        ];
        $status = [
            'unconfirmed' => ['value' => 'Chờ xác nhận.', 'class' => 'text-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận.', 'class' => 'text-primary'],
            'shipping' => ['value' => 'Đang giao hàng.', 'class' => 'text-warning'],
            'delivered' => ['value' => 'Đã giao hàng.', 'class' => 'text-primary'],
            'completed' => ['value' => 'Hoàn thành.', 'class' => 'text-success'],
            'canceled' => ['value' => 'Hủy đơn.', 'class' => 'text-danger'],
        ];

        return view('client.order.list', compact('orders', 'status', 'payment_method', 'payment_status'));
    }

    public function detail(Order $order)
    {
        if ($order->user_id != Auth::user()->id) {
            abort(404);
        }
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
            'ATM' => 'Thanh toán qua VNPay.',
        ];
        $payment_status = [
            'unpaid' => ['value' => 'Chưa thanh toán', 'class' => 'text-secondary'],
            'paid' => ['value' => 'Đã thanh toán', 'class' => 'text-success'],
            'refunded' => ['value' => 'Hoàn trả', 'class' => 'text-warning'],
            'cancel' => ['value' => 'Hủy thanh toán', 'class' => 'text-danger'],
        ];

        return view('client.order.detail', compact('order', 'orderItems', 'status', 'payment_method', 'payment_status'));
    }

    public function cancel(Order $order)
    {
        try {
            if ($order->status != 'unconfirmed') {
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

        session([
            'voucher' => [
                'code' => $voucher->code,
                'value' => $voucher->value,
                'product_id' => $voucher->product_id
            ]
        ]);

        return redirect()->back()->with('success', 'Mã giảm giá đã được áp dụng.');
    }

    public function vnpay($order_id, $total, $order_code)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('order.vnpay-confirm');
        $vnp_TmnCode = "NCWDQX6S";
        $vnp_HashSecret = "JZ35E7TC0I5MW025L9KNN08LOJMPO2PX";

        $vnp_TxnRef = $order_code . '_' . time();
        $vnp_OrderInfo = 'Thanh toán';
        $vnp_OrderType = 'Freak Sport';
        $vnp_Amount = $total;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            return redirect()->away($vnp_Url);
        } else {
            echo json_encode($returnData);
        }
    }

    public function vnpay_confirm(Request $request)
    {
        $data = $request->all();
        $order_code = explode('_', $data['vnp_TxnRef'])[0];
        $order = Order::where('order_code', $order_code)->first();

        if (!$order) {
            session()->forget('voucher');
            return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng.');
        }

        if ($data['vnp_ResponseCode'] == 00 && $data['vnp_TransactionStatus'] == 00) {
            $order->update([
                'status' => 'unconfirmed',
                'payment_status' => 'paid'
            ]);
            $voucher = session()->get('voucher');

            if ($voucher) {
                Voucher::where('code', $voucher['code'])->decrement('quantity', 1);
            }

            session()->forget('cart');
            session()->forget('voucher');

            $encryptedId = Crypt::encryptString($order->id);

            return redirect()->route('order.checkout', $encryptedId)->with('success', 'Tạo đơn hàng thành công.');
        } else {

            session()->forget('voucher');
            session()->forget('cart');

            return redirect()->route('home')->with('error', 'Đã hủy đơn hàng.');
        }
    }

    public function momo($data, $order_code, $total, $order_id)
    {

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = env('MOMO_PARTNERCODE');
        $accessKey = env('MOMO_ACCESSKEY');
        $secretKey = env('MOMO_SECRETKEY');

        $orderInfo = "Thanh toán qua MoMo";
        $amount = $total;
        $orderId = $order_code . '_' . time();
        $redirectUrl = route('order.momo-confirm', $order_id);
        $ipnUrl = route('order.momo-confirm', $order_id);
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithCC";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        return redirect()->to($jsonResult['payUrl']);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo_confirm(Request $request, Order $order)
    {
        $data = $request->all();
        if (!$order) {
            session()->forget('voucher');
            return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng.');
        }

        if ($data['resultCode'] == 0) {
            $order->update([
                'status' => 'unconfirmed',
                'payment_status' => 'paid'
            ]);
            $voucher = session()->get('voucher');

            if ($voucher) {
                Voucher::where('code', $voucher['code'])->decrement('quantity', 1);
            }

            session()->forget('cart');
            session()->forget('voucher');
            $encryptedId = Crypt::encryptString($order->id);

            return redirect()->route('order.checkout', $encryptedId)->with('success', 'Tạo đơn hàng thành công.');
        } else {

            session()->forget('voucher');
            session()->forget('cart');

            return redirect()->route('home')->with('error', 'Đã hủy đơn hàng.');
        }
    }
}
