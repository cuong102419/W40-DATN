<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticController extends Controller
{
    public function index()
    {
        return view('auth.signin');
    }

    public function formSignup() {
        return view('auth.signup');
    }

    public function signin(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);
        // dd($data);
        if (Auth::attempt($data)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard.index');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('signin');
        }
    }

    public function signup(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'min:4'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:password']
        ]);
        // dd($data);
        User::create($data);

        return redirect()->route('signin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('signin');
    }

    public function profile()
    {
        return view('client.user.index');
    }
}
