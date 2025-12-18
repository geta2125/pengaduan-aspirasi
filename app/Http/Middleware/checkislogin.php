<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkislogin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login menggunakan Auth
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }
        // kalau sudah login tapi lagi akses /login atau /login (POST) → lempar ke dashboard
        if ($request->routeIs('login', 'login.process')) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
