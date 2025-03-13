<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        if (Auth::check() && Auth::user()->role_id === 1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id === 1) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
            Auth::logout();
            return back()->withErrors([
                'email' => 'Bu alan için yetkiniz bulunmamaktadır.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz bilgiler hatalı.',
        ]);
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
