@extends('admin.layout.master')

@section('title')
    Danh sách khuyến mãi
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded min vh-100 p-4">
                <h6 class="mb-4">Danh sách khuyến mãi</h6>
                @if (session('success'))
                    <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="text-end">
                    <a href="{{ route('admin-voucher.create') }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus me-2"></i>Tạo mới</a>
                </div>
                <div class="table-responsive mt-3">
                    @if ($vouchers->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên khuyến mãi</th>
                                    <th scope="col">Mã khuyến mãi</th>
                                    <th scope="col">Giá trị khuyến mãi</th>
                                    <th>Số lượng mã</th>
                                    <th scope="col">Ngày bắt đầu</th>
                                    <th scope="col">Ngày kết thúc</th>
                                    

                                    
                                    <th scope="col" class="text-nowrap text-center" style="width:1px">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $index => $voucher)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $voucher->name }}</td>
                                        <td>{{ $voucher->code }}</td>
                                        <td class="text-danger"><b>{{ number_format($voucher->value) }}đ</b></td>
                                        <td>{{ $voucher->quantity }}</td>
                                        <td>{{ $voucher->expiration_date }}</td>
                                        <td>{{ $voucher->created_at->format('d-m-Y') }}</td>
                                        
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin-voucher.edit', $voucher->id) }}" class="btn text-primary ms-2"
                                                    title="Sửa"><i class="fas fa-pen"></i></a>
                                                <form method="post" action="{{ route('admin-voucher.delete', $voucher->id) }}"
                                                    class="ms-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="Xóa" class="btn text-danger"
                                                        onclick="return confirm('Bạn có chắc muốn xóa.')"><i
                                                            class="far fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $vouchers->links() }}
                    @else
                        <h2>Chưa có thương khuyến mãi.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection