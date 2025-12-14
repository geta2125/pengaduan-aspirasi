<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // belum login
        if (!Auth::check()) {
            return redirect()
                ->route('login') // sesuaikan kalau route login kamu beda
                ->with('swal', [
                    'icon'  => 'warning',
                    'title' => 'Oops...',
                    'text'  => 'Anda belum login.',
                ]);
        }

        $userRole = strtolower(trim(Auth::user()->role ?? ''));
        $allowed  = array_map(fn($r) => strtolower(trim($r)), $roles);

        // role user tidak termasuk yang diizinkan
        if (!in_array($userRole, $allowed, true)) {
            return redirect()
                ->back()
                ->with('swal', [
                    'icon'  => 'error',
                    'title' => 'Akses ditolak',
                    'text'  => 'Anda tidak punya akses.',
                ]);
        }

        return $next($request);
    }
}
