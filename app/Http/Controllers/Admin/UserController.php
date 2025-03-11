<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function listUser()
    {
        $users = User::latest('id')->where('id', '!=', Auth::user()->id)->paginate(10);
        $status = [
            1 => ['value' => 'Hoạt động', 'class' => 'text-success'],
            0 => ['value' => 'Vô hiệu hóa', 'class' => 'text-danger']
        ];
        return view('users.list', compact('users', 'status'));
    }
    public function edit(Request $request, User $user) {
        // dd($request);
        $user->status = $request->status;
        $user->save();
        return redirect()->back()->with('success', 'Cập nhật thành công.');
    }
}
