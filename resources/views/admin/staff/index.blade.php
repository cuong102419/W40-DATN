@extends('admin/layout/master')

@section('title')
    Nhân viên
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-light rounded min vh-100 p-4">
                <div class="">
                    <div class="d-flex align-items-center">
                        <h6 class="title">Danh sách nhân viên</h6>
                        </a>
                    </div>
                </div>

                <div>
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('admin-staff.index') }}">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <label for="date">Chọn ngày:</label>
                                    <input type="date" class="form-control form-control-sm" name="date" id="date"
                                        value="{{ request('date') }}">
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary mt-3"><i class="fas fa-filter"></i> Lọc</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class=" table-responsive bg-white ps-3 pe-3">
                        <table class="table mt-4 table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>EMAIL</th>
                                    <th>Chức năng</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $index => $staff)
                                    <tr class="text-center">
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>
                                            <span>Nhân viên</span>
                                        </td>
                                        <td>
                                            <span
                                                class=" fw-bold {{ $status[$staff->status]['class'] }}">{{ $status[$staff->status]['value'] }}</span>
                                        </td>
                                        <td>
                                            {{ $staff->created_at->format('d \T\h\á\n\g m, Y') }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin-staff.status', $staff->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                @if ($staff->status == 1)
                                                    <button class="btn text-danger" name="action" value="ban"
                                                        type="submit"
                                                        onclick="return confirm('Bạn có muốn khóa tài khoản nây.')"><i
                                                            class="fas fa-ban"></i></button>
                                                @else
                                                    <button class="btn text-primary" name="action" value="unban"
                                                        type="submit"
                                                        onclick="return confirm('Bạn có muốn mo khoa tài khoản nây.')"><i
                                                            class="fas fa-unlock-alt"></i></button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $staffs->links() }} --}} 
                    </div>
                </div>
            </div>
        </div>
        @vite('resources/js/user.js')
    @endsection
