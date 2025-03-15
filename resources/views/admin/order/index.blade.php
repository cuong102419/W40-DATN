@extends('admin.layout.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Danh sách đơn hàng</h6>
            <div class="table-responsive">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th class="text-nowrap" style="width:1px">Mã đơn hàng</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Ngày tạo</th>
                            <th class="text-nowrap" style="width:1px">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <div>
                                        <span>{{ $payment_method[$order->payment_method] }}</span>
                                    </div>
                                    <div>
                                        <span class="{{$payment_status[$order->payment_status]['class']}} fw-bold">{{ $payment_status[$order->payment_status]['value']}}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $status[$order->status]['class'] }}">{{ $status[$order->status]['value'] }}</span>
                                </td>
                                <td>
                                    <span class="text-danger fw-bold">{{ number_format($order->total, 0, '.', '.') }}đ</span>
                                </td>
                                <td>
                                    {{ $order->created_at->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    <a href="" class="btn text-primary"><i class="fas fa-pen"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection