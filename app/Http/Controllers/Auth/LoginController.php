<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class LoginController extends Controller
{
    // ==============================
    // LOGIN ADMIN / USER BIASA
    // ==============================
    public function login()
    {
        if (Auth::check()) {
            // kalau sudah login, arahkan sesuai role juga (optional tapi aman)
            $user = Auth::user();
            return $user->role === 'guest'
                ? redirect()->route('pengaduan.index')
                : redirect()->route('dashboard');
        }

        $lastemail = Session::get('last_email');

        return view('auth_admin.login', [
            'lastemail' => $lastemail,
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->messages()->first())->withInput();
        }

        Session::put('last_email', $request->email);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Update last login
            $user->last_login = Carbon::now();
            $user->save();

            // Simpan data user ke session
            Session::put('userData', $user->toArray());
            Session::forget('last_email');

            // redirect sesuai role
            if ($user->role === 'guest') {
                return redirect()->route('pengaduan.index')
                    ->with('success', 'Login berhasil sebagai Guest.');
            }

            if ($user->role == 'petugas') {
                return redirect()->route('pengaduan.index')
                    ->with('success', 'Login berhasil sebagai Petugas.');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil sebagai ' . ucfirst($user->role) . '.');
        }

        return redirect()->route('login')
            ->with('error', 'email atau password salah.')
            ->withInput();
    }

    // ==============================
    // LOGOUT
    // ==============================
    public function logout(Request $request)
    {
        Session::forget('userData');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('login')
            ->with('success', 'Logout berhasil, sampai jumpa lagi!');
    }
}
