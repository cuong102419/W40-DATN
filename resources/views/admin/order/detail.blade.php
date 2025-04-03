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
                        <form action="{{ route('admin-order.status', $order->id) }}" method="post" id="confirm-order">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="">
                            @if ($order->status == 'unconfirmed')
                                <button onclick="return confirm('Bạn có muốn xác nhận đơn hàng này.')" type="submit"
                                    name="action" value="confirmed" class="btn btn-sm btn-primary"><i
                                        class="fas fa-check me-2"></i>Xác nhận</button>
                                @if (!$requestOrder)
                                    <a data-bs-toggle="modal" data-bs-target="#reason-cancel"
                                        class="btn btn-sm btn-danger"><i class="far fa-window-close me-2"></i>Hủy</a>
                                @endif
                            @elseif ($order->status == 'confirmed')
                                <button type="submit" name="action" value="shipping" class="btn btn-sm btn-primary"><i
                                        class="fas fa-shipping-fast me-2"></i>Giao hàng</button>
                            @elseif ($order->status == 'shipping')
                                <button type="submit" name="action" value="delivered" class="btn btn-sm btn-primary"><i
                                        class="fas fa-truck-loading me-2"></i>Hoàn thành giao hàng</button>
                            @elseif ($order->status == 'delivered')
                                <button type="submit" name="action" value="completed" class="btn btn-sm btn-success"><i
                                        class="fas fa-check me-2"></i>Hoàn thành</button>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="bg-white mt-3 p-2">
                    <div class="table-responsive">
                        <table class="table">
                            @if ($requestOrder)
                                <tr>
                                    <th>Yêu cầu hủy đơn</th>
                                    <td>
                                        <div>
                                            <strong>Lý do hủy đơn: </strong>{{ $requestOrder->reason }}
                                        </div>
                                        <div>
                                            <span>Ngày tạo:
                                                {{ $requestOrder->created_at->format('d \T\h\á\n\g m, Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <form class="cancel-order" action="{{ route('admin-order.cancel', $order->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <input hidden name="reason" value="{{ $requestOrder->reason }}">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có muốn hủy đơn hàng này.')">Xác nhận hủy đơn</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>Mã đơn hàng</th>
                                <td colspan="2">{{ $order->order_code }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái đơn hàng</th>
                                <th>
                                    <span
                                        class="{{ $status[$order->status]['class'] }}">{{ $status[$order->status]['value'] }}</span>
                                </th>
                                <td>
                                    @if ($order->status == 'returned' || $order->status == 'canceled' || $order->status == 'failed') 
                                        <span><strong>Lý do: </strong> {{ $order->reason }}</span>
                                    @endif
                                </td>
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
                                                    <span
                                                        class="fw-bold">{{ $item->product_variant->product->name }}</span>
                                                </div>
                                                <div>
                                                    <span><strong>Số lượng:</strong> {{ $item->quantity }}</span>
                                                </div>
                                                <div>
                                                    <span><strong>Kích cỡ:</strong>
                                                        {{ $item->product_variant->size }}</span>
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
                                        <span>{{ number_format($item->unit_price, 0, '.', '.') }}đ</span>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>Giảm giá</th>
                                <td colspan="2">
                                    <span class="">{{ number_format($order->discount_amount, 0, '.', '.') }}đ</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Vận chuyển</th>
                                <td colspan="2">
                                    <span class="">{{ number_format($order->shipping, 0, '.', '.') }}đ</span>
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
                                                    <option value="paid"
                                                        {{ $order->payment_status == 'paid' ? 'disabled selected' : '' }}>
                                                        Đã thanh toán</option>
                                                    <option value="refunded"
                                                        {{ $order->payment_status == 'refunded' ? 'disabled selected' : '' }}>
                                                        Hoàn trả</option>
                                                    <option value="cancel"
                                                        {{ $order->payment_status == 'cancel' ? 'disabled selected' : '' }}>
                                                        Đã hủy</option>
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
                                    <span>{{ $day }},
                                        {{ $order->created_at->format('d \t\h\á\n\g m, Y') }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-5">
                        <h5>Thông tin khách hàng</h5>
                        <form id="custom-info" action="{{ route('admin-order.info', $order->id) }}" method="post"
                            class="mt-3">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col">
                                    <label for="" class="form-label">Họ tên</label>
                                    <input type="text" name="fullname" class="form-control"
                                        value="{{ $order->fullname }}">
                                    <span class="text-danger error-fullname mt-2 d-block"></span>
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ $order->phone_number }}">
                                    <span class="text-danger error-phone-number mt-2 d-block"></span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ $order->email }}">
                                    <span class="text-danger error-email mt-2 d-block"></span>
                                </div>
                                <div class="col">
                                    <label for="" class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ $order->address }}">
                                    <span class="text-danger error-address mt-2 d-block"></span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Ghi chú</label>
                                <textarea class="form-control" name="note" rows="5" name="" id="">{{ $order->note }}</textarea>
                            </div>
                            <div class="mt-3">
                                <button type="submit"
                                    onclick="return confirm('Bạn có muốn cập nhật thông tin khách hàng.')"
                                    class="btn btn-sm btn-primary"><i class="fas fa-save me-2"></i>Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reason-cancel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="cancel-order" action="{{ route('admin-order.cancel', $order->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h6 class="modal-title">Hủy đơn hàng</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div>
                            <textarea name="reason" class="form-control" id="" cols="20" rows="5"
                                placeholder="Nhập lý do hủy đơn hàng"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có muốn hủy đơn hàng này.')">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#confirm-order button[type="submit"]').click(function() {
            let actionValue = $(this).val();
            $('#confirm-order input[name="action"]').val(actionValue);
        });
    </script>
    <script src="{{ asset('administrator/js/order.js') }}"></script>
@endsection
