@extends('admin.layout.master')

@section('title')
    Danh sách bài viết
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Danh sách bài viết</h6>

                @if (session('success'))
                    <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="text-end">
                    <a href="{{ route('admin-blog.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-2"></i> Thêm bài viết mới
                    </a>
                </div>

                <div class="table-responsive mt-3">
                    @if ($blogs->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Tác giả</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $index => $blog)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->author }}</td>
                                        <td>
                                            @if ($blog->image_url)
                                                <img src="{{ asset('storage/' . $blog->image_url) }}" width="100" class="rounded">
                                            @else
                                                <span class="text-muted">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin-blog.edit', $blog->id) }}" class="btn btn-warning btn-sm me-2" title="Sửa">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin-blog.delete', $blog->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa" 
                                                        onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $blogs->links() }}
                    @else
                        <h4 class="text-center text-muted">Chưa có bài viết nào.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
    