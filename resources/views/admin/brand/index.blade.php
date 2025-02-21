@extends('admin.layout.master')

@section('title')
    Danh sách thương hiệu
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded min vh-100 p-4">
                <h6 class="mb-4">Danh sách danh mục</h6>
                @if (session('success'))
                    <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="text-end">
                    <a href="{{ route('admin-brand.create') }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus me-2"></i>Tạo mới</a>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên thương hiệu
                                <th scope="col">Ngày tạo</th>
                                <th scope="col" class="text-nowrap text-center" style="width:1px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <th scope="row">{{ $brand->id }}</th>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin-brand.edit', $brand->id) }}" class="btn text-primary ms-2" title="Sửa"><i class="fas fa-pen"></i></a>
                                            <form method="post" action="{{ route('admin-brand.delete', $brand->id) }}" class="ms-2">
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
                    {{ $brands->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection