<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);
        
        if(Auth::attempt($data)) {
            if(Auth::user()->role == 'admin') {
                return redirect()->route('dashboard.index');
            }
        } else {
            return redirect()->route('login.index');
        }
    }

    public function signup(Request $request) {
        // dd($request);
        $data = $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required', 'min:4'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:password']
        ]);
        
        User::create($data);
        
        return redirect()->route('home');

    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login.index');
    }
}
