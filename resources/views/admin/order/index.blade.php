@extends('admin.layout.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Danh sách đơn hàng</h6>
                <div class="bg-white p-3">
                    <div class="table-responsive">
                        <table class="table table-striped text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <th>{{ $order->order_code }}</th>
                                        <td class="text-start text-nowrap" style="width:1px">
                                            <ul>
                                                <li>{{ $order->fullname }}</li>
                                                <li>{{ $order->phone_number }}</li>
                                                <li>{{ $order->email }}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div>
                                                <span>{{ $payment_method[$order->payment_method] }}</span>
                                            </div>
                                            <div>
                                                <small
                                                    class="{{$payment_status[$order->payment_status]['class']}} fw-bold">{{ $payment_status[$order->payment_status]['value']}}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="fw-bold {{ $status[$order->status]['class'] }}">{{ $status[$order->status]['value'] }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark fw-bold">{{ number_format($order->total, 0, '.', '.') }}đ</span>
                                        </td>
                                        <td class="text-start">
                                            {{ $order->created_at->format('d \t\h\g m, Y') }}
                                        </td>
                                        <td class="text-nowrap" style="width:1px">
                                            <a href="{{ route('admin-order.detail', $order->id) }}" class="btn text-primary"><i
                                                    class="fas fa-pen"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
@endsection