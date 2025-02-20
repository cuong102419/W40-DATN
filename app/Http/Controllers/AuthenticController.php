<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticController extends Controller
{
    public function login() {
        return view('client.signin.login');
    }
}
