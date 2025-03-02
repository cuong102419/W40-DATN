@extends('client.layout.master')

@section('title')
    Đổi mật khẩu
@endsection

@section('content')
    <div class="mt-5 mb-5">
        <div class="row">
            <div class="col-sm-8 m-auto">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <span>{{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                <div class="section-title text-center">
                    <h2 class=" text-uppercase">Đổi mật khẩu</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="login-form-content">
                    <form action="{{ route('update-password', Auth::user()->id) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Mật khẩu cũ <span class="required">*</span></label>
                                    <input class="form-control" type="password" name="password">
                                    @error('password')
                                        <span class="mt-3 text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Mật khẩu mới <span class="required">*</span></label>
                                    <input class="form-control" type="password" name="new_password">
                                    @error('new_password')
                                        <span class="mt-3 text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nhập lại mật khẩu mới <span class="required">*</span></label>
                                    <input class="form-control" type="password" name="confirm_new_password">
                                    @error('confirm_new_password')
                                        <span class="mt-3 text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn-login" type="submit">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
