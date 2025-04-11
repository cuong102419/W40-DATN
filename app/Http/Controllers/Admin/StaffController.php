<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index() {
        $staffs = User::where('role', 'staff')->get();   

        $status = [
            1 => ['value' => 'Hoạt động', 'class' => 'text-success'],
            0 => ['value' => 'Vô hiệu hóa', 'class' => 'text-danger']
        ];

        return view('admin.staff.index', compact('staffs', 'status'));
    }
    
    public function status(Request $request, User $user) {
        $action = $request->input('action');
        if($action == 'ban') {
            $user->status = 0;
            $user->save();
        }

        if ($action == 'unban') { 
            $user->status = 1;
            $user->save();
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái tài khoản thành công.');

    }
}
