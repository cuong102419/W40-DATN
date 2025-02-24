<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        dd($request);
    }

    public function signup(Request $request) {
        dd($request);
    }
}
