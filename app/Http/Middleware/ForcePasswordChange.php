<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    /**
     * İlk kez giriş yapan kullanıcıları şifre değiştirme sayfasına yönlendirir.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Eğer kullanıcı giriş yapmışsa ve şifreyi değiştirmemişse
        if (Auth::check() && !Auth::user()->password_changed) {
            // Eğer şifre değiştirme sayfasına girmiyorsa yönlendir
            if (!$request->is('password/change') && !$request->is('logout')) {
                return redirect()->route('password.change')->with('warning', 'İlk girişinizde şifrenizi değiştirmeniz gerekmektedir.');
            }
        }

        return $next($request);
    }
}
