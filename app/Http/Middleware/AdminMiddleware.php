<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role_id !== 1) {
            Auth::logout();
            return redirect('/admin/login')->withErrors([
                'email' => 'Bu alana erişim yetkiniz bulunmamaktadır.',
            ]);
        }

        return $next($request);
    }
}
