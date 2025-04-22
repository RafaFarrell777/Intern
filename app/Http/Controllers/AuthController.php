<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register() {
        return view("auth/register");
    }

    public function signup(Request $req) {
        $validator = Validator::make($req->all(), [
            "name" => "required|max:255",
            "email" => "required|email|max:255",
            "password"=> "required|string|min:6|max:255"
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.register')
                ->withErrors($validator)
                ->withInput($req->except('password'));
        }

        $user = User::create($req->all());
        if (Auth::attempt(["email"=> $user->email,"password"=> $user->password])) {
            return redirect("/")->with('success', 'Register sukses!');
        }

        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function login()
    {
        return view("auth/login");
    }

    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|max:255",
            "password"=> "required|string|min:6|max:255"
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('auth.login')
                ->withErrors($validator)
                ->withInput($request->all());
        }

        if (Auth::attempt($request->only(["email", "password"]))) {
            $user = Auth::user();
            if ($user->role === 'mentor') {
                return redirect()->route('dashboard')->with('success', 'Login berhasil!');
            } else {
                return redirect()->route('landing')->with('success', 'Login berhasil!');
            }
        } else {
            if (!User::where('email', '=', strtolower($request->email))->exists()) {
                return redirect()->route('auth.login')->withErrors(['email' => 'Email tidak terdaftar!']);
            } else {
                return redirect()->route('auth.login')->withErrors(['password' => 'Password salah!']);
            }
        }
    }

    public function logout(Request $req)
    {
        Auth::guard('web')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/login');
    }
}
