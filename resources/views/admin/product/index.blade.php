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
                    <a href="{{ route('admin-product.create') }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus me-1"></i>Thêm mới</a>
                </div>
                <div class="table-responsive">
                    @if ($products->isNotEmpty())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Mã sản phẩm</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Thương hiệu</th>
                                <th>Danh mục</th>
                                <th scope="col" style="width: 10%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <th scope="row">{{ $index + 1}}</th>
                                    <td>{{ $product->sku }}</td>
                                    <td>
                                        @if ($product->imageLists->isNotEmpty())
                                            <img src="{{ Storage::url($product->imageLists->first()->image_url) }}" width="100" alt="">
                                        @else
                                            Chưa có ảnh nào.
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->variants->sum('quantity') }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin-product.detail', $product->id) }}"
                                                class="btn text-primary ms-2" title="Chi tiết sản phẩm"><i
                                                    class="fas fa-info-circle fa-lg"></i></a>
                                            <form action="{{ route('admin-product.delete',$product->id) }}" method="post" class="ms-2">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn text-danger"
                                                    onclick="return confirm('Bạn có muốn xóa sản phẩm này.')"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <h2>Chưa có sản phẩm nào</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection