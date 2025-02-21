@extends('admin.layout.master')

@section('title')
    Danh sách sản phẩm
@endsection

@section('content')
    <!-- Table Start -->
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Danh sách sản phẩm</h6>
                <div class="mb-4 text-end">
                    <a href="{{ route('admin-product.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i>Thêm mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mã sản phẩm</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col" style="width: 10%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('admin-product.detail') }}" class="btn text-primary ms-2" title="Chi tiết sản phẩm"><i class="fas fa-info-circle fa-lg"></i></a>
                                        <form action="#" class="ms-2">
                                            <button class="btn text-danger" onclick="return confirm('Mày có muốn xóa nó.')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>mark@email.com</td>
                                <td>UK</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>jacob@email.com</td>
                                <td>AU</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection