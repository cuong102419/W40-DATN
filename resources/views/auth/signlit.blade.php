@extends('admin/layout/master')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Khách hàng</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Khách hàng</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Danh sách khách hàng</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Danh sách khách hàng</h4>
                            <a href="" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Thêm mới khách hàng
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>FULL NAME</th>
                                    <th>USER NAME</th>
                                    <th>EMAIL</th>
                                    <th>ROLE</th>
                                    <th>ACTIVE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($auths as $index => $auth)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $auth->fullname }}</td>
                                        <td>{{ $auth->username }}</td>
                                        <td>{{ $auth->email }}</td>
                                        <td>{{ $auth->role }}</td>
                                        <td>
                                            {!! $auth->active
                                                ? '<span class="badge text-bg-primary" >Hoạt động</span>'
                                                : '<span class="badge text-bg-danger" >Khóa</span>' !!}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn" title="Edit" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $index }}">
                                                <i class="fa fa-pen"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <form action="{{ route('admin.editActive', $auth->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa quền truy cập
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="1" @checked($auth->active == 1)
                                                                    name="active" id="flexRadioDefault1{{$index}}">
                                                                <label class="form-check-label fw-bold" for="flexRadioDefault1{{$index}}">
                                                                    Hoạt động
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="active" id="flexRadioDefault2{{$index}}" 
                                                                    value="0" @checked($auth->active == 0)>
                                                                <label class="form-check-label text-danger fw-bold" for="flexRadioDefault2{{$index}}">
                                                                    Khóa
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
