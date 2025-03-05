<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Socialite\Facades\Socialite;

class SigninGoogleController extends Controller
{
    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();

    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                if ($finduser->status == 0) {
                    return redirect()->route('signin')->with('error', 'Tài khoản của bạn đã bị khóa.');
                }

                if ($finduser->role == 'admin') {
                    Auth::login($finduser);

                    return redirect()->route('dashboard.index');
                }

                return redirect()->intended('/');
            } else {

                $newUser = User::updateOrCreate(['email' => $user->email], [

                    'name' => $user->name,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy')

                ]);

                Auth::login($newUser);

                return redirect()->intended('/');

            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
