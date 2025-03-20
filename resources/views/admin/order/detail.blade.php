@extends('admin.layout.master')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h4 class="mb-4">Chi tiết đơn hàng</h4>
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ route('admin-order.index') }}" class="btn btn-secondary btn-sm"><i
                                class="fas fa-arrow-left me-2"></i>Danh sách</a>
                    </div>
                    <div>
                        <form action="{{ route('admin-order.status', $order->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            @if ($order->status == 'unconfirmed')
                                <button onclick="return confirm('Bạn có muốn xác nhận đơn hàng này.')" type="submit" name="action" value="confirmed" class="btn btn-sm btn-primary"><i class="fas fa-check me-2"></i>Xác nhận</button>
                                <button onclick="return confirm('Bạn có muốn hủy, nếu hủy sẽ không thể hoàn tác lại.')" type="submit" name="action" value="canceled" class="btn btn-sm btn-danger"><i class="fas fa-ban me-2"></i>Hủy</button>
                            @elseif ($order->status == 'confirmed')
                                <button type="submit" name="action" value="shipping" class="btn btn-sm btn-primary"><i class="fas fa-shipping-fast me-2"></i>Giao hàng</button>
                            @elseif ($order->status == 'shipping')
                                <button type="submit" name="action" value="delivered" class="btn btn-sm btn-primary"><i class="fas fa-truck-loading me-2"></i>Hoàn thành giao hàng</button>
                            @elseif ($order->status == 'delivered')
                                <button type="submit" name="action" value="completed" class="btn btn-sm btn-success"><i class="fas fa-check me-2"></i>Hoàn thành</button>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="bg-white mt-3 p-2">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Trạng thái đơn hàng</th>
                                <th>
                                    <span
                                        class="{{ $status[$order->status]['class'] }}">{{ $status[$order->status]['value'] }}</span>
                                </th>
                            </tr>
                            <tr>
                                <th>Sản phẩm</th>
                                <th colspan="2">Giá</th>
                            </tr>
                            @foreach ($orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <span>
                                                    <img src="{{ Storage::url($item->product_variant->product->imageLists->first()->image_url) }}"
                                                        width="100" alt="">
                                                </span>
                                            </div>
                                            <div class="ms-3">
                                                <div>
                                                    <span class="fw-bold">{{ $item->product_variant->product->name }}</span>
                                                </div>
                                                <div>
                                                    <span><strong>Số lượng:</strong> {{ $item->quantity }}</span>
                                                </div>
                                                <div>
                                                    <span><strong>Kích cỡ:</strong> {{ $item->product_variant->size }}</span>
                                                </div>
                                                <div class="d-flex">
                                                    <div>
                                                        <span class="fw-bold">Màu sắc:</span>
                                                    </div>
                                                    <div class="rounded-circle border border-secondary shadow mt-1 ms-2"
                                                        style="width: 16px; height: 16px; background-color: {{ $item->product_variant->color }}; display: inline-block;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <span class="fw-bold">{{ number_format($item->unit_price, 0, '.', '.') }}đ</span>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>Giảm giá</th>
                                <td colspan="2">
                                    <span
                                        class="">{{ number_format($order->discount_amount, 0, '.', '.') }}đ</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Vận chuyển</th>
                                <td colspan="2">
                                    <span
                                        class="">{{ number_format($order->shipping, 0, '.', '.') }}đ</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tổng cộng</th>
                                <td colspan="2">
                                    <span
                                        class="text-danger fw-bold">{{ number_format($order->total, 0, '.', '.') }}đ</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Phương thức thanh toán</th>
                                <td>
                                    <div>
                                        <span>{{ $payment_method[$order->payment_method] }}</span>
                                    </div>
                                    <div>
                                        <span>Trạng thái: <strong
                                                class="{{ $payment_status[$order->payment_status]['class'] }}">{{ $payment_status[$order->payment_status]['value'] }}</strong></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="w-75">
                                        <form action="{{ route('admin-order.payment', $order->id) }}" method="post"
                                            id="payment-status">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <select name="payment_status" class="form-select" id="">
                                                    <option disabled selected>--Chọn--</option>
                                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'disabled selected' : '' }}>Đã thanh toán</option>
                                                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'disabled selected' : '' }}>Hoàn trả</option>
                                                    <option value="cancel" {{ $order->payment_status == 'cancel' ? 'disabled selected' : '' }}>Đã hủy</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-sm btn-primary"><i
                                                        class="fas fa-save me-2"></i>Cập nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày tạo</th>
                                <td colspan="2">
                                    <span>{{$day}}, {{ $order->created_at->format('d \t\h\á\n\g m, Y') }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-5">
                        <h5>Thông tin khách hàng</h5>
                        <form action="{{ route('admin-order.info', $order->id) }}" method="post" class="mt-3">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col">
                                    <label for="" class="form-label">Họ tên</label>
                                    <input type="text" name="fullname" class="form-control" value="{{ $order->fullname }}">
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ $order->phone_number }}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{ $order->email }}">
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="{{ $order->address }}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Ghi chú</label>
                                <textarea class="form-control" name="note" rows="5" name=""
                                    id="">{{ $order->note}}</textarea>
                            </div>
                            <div class="mt-3">
                                <button type="submit" onclick="return confirm('Bạn có muốn cập nhật thông tin khách hàng.')"
                                    class="btn btn-sm btn-primary"><i class="fas fa-save me-2"></i>Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('administrator/js/order.js') }}"></script>
@endsection