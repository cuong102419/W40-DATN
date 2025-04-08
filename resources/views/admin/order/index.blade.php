@extends('admin.layout.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Danh sách đơn hàng</h6>
                <div class="row mb-3 justify-content-between">
                    <div class="col-12 col-sm-4">
                        <form class="d-none d-md-flex ms-4">
                            <div class="input-group input-group-sm">
                                <input class="form-control border-0" type="text"
                                    placeholder="Tìm kiếm đơn hàng theo mã">
                                <button type="submit" class="input-group-text bg-primary text-light"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-sm-4">
                        <form action="#" method="post">
                            <div class="d-flex align-items-center">
                                <div class="w-75 me-2">
                                    <select name="" id="" class="form-select form-select-sm">
                                        <option value="" selected>Tất cả</option>
                                        <option value="">Chưa xác nhận</option>
                                        <option value="">Đã xác nhận</option>
                                        <option value="">Hoàn thành</option>
                                        <option value="">Đơn đã hủy</option>
                                        <option value="">Đơn hoàn trả</option>
                                    </select>
                                </div>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-white p-3">
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
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