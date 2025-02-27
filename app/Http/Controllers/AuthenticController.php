<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard.index');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function signup(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'min:4'],
            'phone_number' => ['required', 'min:10'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:password']
        ]);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('client.user.index');
    }
}
