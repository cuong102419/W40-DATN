@extends('admin.layout.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng số người dùng</p>
                        <h6 class="mb-0">{{ $totalUsers }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-clipboard fa-3x text-warning"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng số đơn hàng đã bán</p>
                        <h6 class="mb-0">{{ $totalOrders }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-gift fa-3x text-danger"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng số lượt bán sản phẩm</p>
                        <h6 class="mb-0">{{ $totalSales }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-wallet fa-3x text-success"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng doanh thu trong tháng</p>
                        <h6 class="mb-0">{{ number_format($totalRevenueMonth, 0, '.', '.') }}đ</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->


    <!-- Sales Chart Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-8">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-4">Doanh thu theo tháng</h6>
                        <h6>Tổng doanh thu: <span
                                class="text-danger">{{ number_format($totalRevenue, 0, '.', '.') }}đ</span></h6>
                    </div>
                    <canvas id="line-chart"></canvas>
                </div>
            </div>
            <div class="col-sm-12 col-xl-4">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Tổng số đơn hàng theo trạng thái</h6>
                    <canvas id="pie-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Sales Chart End -->


    <!-- Recent Sales Start -->
    <div class="container-fluid mb-3 pt-4 px-4">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-xl-9">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Danh sách đơn hàng mới</h6>
                        <a href="{{ route('admin-order.index') }}">Xem danh sách</a>
                    </div>
                    <div class="table-responsive bg-white">
                        <table class="table text-start align-middle table-bordered mb-0">
                            <thead class="text-center">
                                <tr class="text-dark">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Thông tin</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thời gian</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @foreach ($quickListOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin-order.detail', $order->id) }}">
                                                {{ $order->order_code }}
                                            </a>
                                        </td>
                                        <td style="width:1px" class="text-nowrap">
                                            <ul>
                                                <li>Họ tên: {{ $order->fullname }}</li>
                                                <li>SĐT: {{ $order->phone_number }}</li>
                                                <li>Email: {{ $order->email }}</li>
                                            </ul>
                                        </td>
                                        <td>{{ number_format($order->total, 0, '.', '.') }}đ</td>
                                        <td><span
                                                class="badge {{ $statusOrder[$order->status]['class'] }}">{{ $statusOrder[$order->status]['value'] }}</span>
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('d \t\h\g m, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0">Top sản phẩm bán chạy</h6>
                    </div>
                    @foreach ($productSale as $sale)
                        <a href="{{ route('admin-product.detail', $sale->id) }}" class="text-secondary">
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class=" rounded flex-shrink-0"
                                    src="{{ Storage::url($sale->imageLists->first()->image_url ?? '') }}" alt=""
                                    width="50">
                                <div class="w-100 ms-3">
                                    <div>
                                        {{-- <small
                                            class="badge bg-primary">{{ number_format($sale->variants->min()->price, 0, '.', '.') }}đ</small> --}}
                                    </div>
                                    <div>
                                        <small class="mb-0"><strong>{{ $sale->sales_count }}</strong> đã bán</small>
                                    </div>
                                    <div>
                                        <small>{{ $sale->name }}</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-8">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Top sản phẩm bán trong tháng</h6>
                        <a href="{{ route('admin-product.index') }}">Xem danh sách</a>
                    </div>
                    <div class="table-responsive bg-white">
                        <table class="table text-start align-middle table-hover mb-0">
                            <thead class="text-center">
                                <tr class="text-dark">
                                    <th scope="col">Mã</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá</th>
                                </tr>
                            </thead>
                            <tbody class="small text-center">
                                @foreach ($productMonth as $product)
                                    <tr>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-nowrap" style="width:1px">
                                            <img src="{{ Storage::url($product->imageLists->first()->image_url) }}"
                                                width="80" alt="">
                                        </td>
                                        <td>{{ $product->variants->sum('quantity') }}</td>
                                        <td>{{ number_format($product->variants->min()->price, 0, '.', '.') }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-light rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0">Top sản phẩm được quan tâm</h6>
                    </div>
                    @foreach ($productView as $view)
                        <div class="d-flex align-items-center border-bottom py-3">
                            <img class=" rounded flex-shrink-0"
                                src="{{ Storage::url($view->imageLists->first()->image_url) }}" alt=""
                                width="60">
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-0">{{ $view->view }} <i class="far fa-eye fa-sm text-primary"></i>
                                    </h6>
                                    <small
                                        class="badge bg-primary">{{ number_format($view->variants->min()->price, 0, '.', '.') }}đ</small>
                                </div>
                                <span>{{ $view->name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->


    <script>
        let orderStatus = @json($orderStatus);

        let labels = Object.keys(orderStatus);
        let data = Object.values(orderStatus);

        let revenueData = @json($revenueMonth);

        let labelsRevenue = Object.keys(revenueData);
        let dataRevenue = Object.values(revenueData);
    </script>
@endsection
