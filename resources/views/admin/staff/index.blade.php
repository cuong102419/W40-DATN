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
                                        <span class=" fw-bold {{$status[$staff->status]['class']}}">{{ $status[$staff->status]['value'] }}</span>
                                    </td>
                                    <td>
                                        {{ $staff->created_at->format('d \T\h\á\n\g m, Y') }}
                                    </td>
                                    <td>
                                        <form action="" method="post">
                                            <button class="btn text-danger" type="submit"><i class="fas fa-ban"></i></button>
                                            <button class="btn text-primary" type="submit"><i class="fas fa-unlock-alt"></i></button>
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
@endsection
