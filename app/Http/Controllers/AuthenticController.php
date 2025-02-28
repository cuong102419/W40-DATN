<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticController extends Controller
{
    public function index()
    {
        return view('auth.signin');
    }

    public function formSignup()
    {
        return view('auth.signup');
    }

    public function signin(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);
        if (Auth::attempt($data)) {
            if (Auth::user()->status == 1) {
                $user = Auth::user();
                if (Auth::user()->role == 'admin') {

                    if ($request->ajax()) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Đăng nhập thành công.',
                            'role' => $user->role
                        ], Response::HTTP_OK);
                    }
                    return redirect()->route('dashboard.index');
                } else {
                    if ($request->ajax()) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Đăng nhập thành công.',
                            'role' => $user->role
                        ], Response::HTTP_OK);
                    }
                    return redirect()->route('home');
                }
            } else {

                if ($request->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tài khoản đã bị khóa.'
                    ], Response::HTTP_UNAUTHORIZED);
                }
            }
        } else {

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email hoặc mật khẩu không chính xác.'
                ], Response::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function signup(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'min:4'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:password']
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không hợp lệ.',
            'name.required' => 'Họ tên không để trống.',
            'name.min' => 'Họ tên tối thiểu 4 ký tự.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu tối thiểu 8 ký tự.',
            'confirm_password.required' => 'Không được bỏ trống.',
            'confirm_password.min' => 'Tối thiểu 8 ký tự.',
            'confirm_password.same' => 'Mật khẩu không khớp,vui lòng nhập lại.'
        ]);

        User::create($data);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tạo tài khoản thành công, hãy đăng nhập lại.'
            ], Response::HTTP_OK);
        }

        return redirect()->route('signin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('signin')->with('success', 'Đăng xuất thành công.');
    }

    public function profile()
    {
        return view('client.user.index');
    }
}
