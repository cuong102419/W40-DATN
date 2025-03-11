@extends('admin/layout/master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-light rounded min vh-100 p-4">
                <div class="">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Danh sách khách hàng</h4>
                        </a>
                    </div>
                </div>
                <div class=" table-responsive">
                    <table class="table mt-4">
                        <thead>
                            <tr class="text-center">
                                <th>STT</th>
                                <th>FULL NAME</th>
                                <th>EMAIL</th>
                                <th>ROLE</th>
                                <th>ACTIVE</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td><span
                                            class="{{ $status[$user->status]['class'] }}">{{ $status[$user->status]['value'] }}</span>
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn text-primary" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal{{ $index }}">
                                            <i class="fa fa-pen"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="{{ route('admin.user.edit', $user) }}" method="POST"
                                                class="modal-dialog">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa
                                                            quền truy cập
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="1"
                                                                @checked($user->status == 1) name="status"
                                                                @if ($user->status == 1)
                                                                    disabled
                                                                @endif
                                                                id="flexRadioDefault1{{ $index }}">
                                                            <label class="form-check-label fw-bold"
                                                                for="flexRadioDefault1{{ $index }}">
                                                                Hoạt động
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status"
                                                            @if ($user->status == 0)
                                                                    disabled
                                                                @endif
                                                                id="flexRadioDefault2{{ $index }}" value="0"
                                                                @checked($user->status == 0)>
                                                            <label class="form-check-label text-danger fw-bold"
                                                                for="flexRadioDefault2{{ $index }}">
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
