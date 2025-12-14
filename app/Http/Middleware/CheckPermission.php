<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $ability)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login dulu.');
        }

        $role = strtolower(Auth::user()->role);

        // Definisi permission per role
        $permissions = [
            'super_admin' => [
                'dashboard.view',
                'tables.index',
                'tables.show',
            ],
            'admin' => [
                'dashboard.view',
                'tables.index',
                'tables.show',
                'tables.create',
                'tables.edit',
                'tables.delete',
                'pengaduan.view',
                'pengaduan.create',
                'pengaduan.edit',
                'pengaduan.delete',
                'tindaklanjut.view',
                'tindaklanjut.create',
                'tindaklanjut.edit',
                'tindaklanjut.delete',
            ],
            'petugas' => [
                'dashboard.view',
                'pengaduan.view',
                'pengaduan.edit',
                'tindaklanjut.view',
                'tindaklanjut.edit',
            ],
        ];

        $allowed = $permissions[$role] ?? [];

        if (!in_array($ability, $allowed)) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk aksi ini.');
        }

        return $next($request);
    }
}
