<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login menggunakan Auth
        if (!Auth::check()) {
            return redirect()->route('auth')->with('error', 'Anda harus login terlebih dahulu.');
        }

        return $next($request);
    }
}
