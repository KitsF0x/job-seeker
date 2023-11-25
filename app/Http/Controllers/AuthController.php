<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    const NAME_VALIDATION = 'required';
    const EMAIL_VALIDATION = 'required|email';
    const PASSWORD_VALIDATION = 'required|min:5';
    const REPEAT_PASSWORD_VALIDATION = 'required_with:password|same:password|min:5';

    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => self::NAME_VALIDATION.'|unique:users',
            'email' => self::EMAIL_VALIDATION.'|unique:users',
            'password' => self::PASSWORD_VALIDATION,
            'password-repeat' => self::REPEAT_PASSWORD_VALIDATION
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        if($user) {
            Auth::login($user);
            return redirect(route('home'));
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => self::EMAIL_VALIDATION,
            'password' => self::PASSWORD_VALIDATION
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect(route('home'));
            }
            else {
                return back()->with('error', 'Password is not correct');
            }
        } else {
            return back()->with('error', 'This email is not registered');
        }
    }

    public function logout()
    {
        Auth::logout();
        return back();
    }

    public function edit() {
        return view('auth.edit', [ 
            'personDetails' => Auth::user()->personDetails
        ]);
    }
}
