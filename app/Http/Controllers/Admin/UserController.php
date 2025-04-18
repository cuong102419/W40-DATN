<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function listUser(Request $request)
    {
        
        $query = User::query();

        if ($request->status === 'confirmed') {
            $query->whereNotNull('email_verified_at');
        } elseif ($request->status === 'unconfirmed') {
            $query->whereNull('email_verified_at');
        }

        $users = $query->latest('id')->where('role', 'user')->paginate(10);
        $status = [
            1 => ['value' => 'Hoạt động', 'class' => 'text-success'],
            0 => ['value' => 'Vô hiệu hóa', 'class' => 'text-danger']
        ];
        $role = [
            'user' => 'Người dùng',
        ];
        return view('admin.users.list', compact('users', 'status', 'role'));
    }
    public function edit(Request $request, User $user)
    {
        try {
            $user->status = $request->status;
            $user->save();
            return redirect()->back()->with('success', 'Cập nhật thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function verify(User $user)
    {
        if (!$user->email_verified_at) {
            $user->email_verified_at = Carbon::now()->format('d-m-Y H:i:s');
            $user->save();
        }

        return redirect()->back()->with('success', 'Xác nhận thành công.');
    }
}
