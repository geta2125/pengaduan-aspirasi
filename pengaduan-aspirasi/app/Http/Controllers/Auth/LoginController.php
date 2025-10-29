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
    // LOGIN ADMIN
    // ==============================
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $lastUsername = Session::get('last_username');

        return view('auth_admin.login', [
            'lastUsername' => $lastUsername,
            'title' => 'Login Admin'
        ]);
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->messages()->first())->withInput();
        }

        Session::put('last_username', $request->username);
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Update last login
            $user->last_login = Carbon::now();
            $user->save();

            // Simpan data user ke session
            Session::put('userData', $user->toArray());
            Session::forget('last_username');

            return redirect()->route('dashboard')->with('success', 'Login berhasil sebagai ' . ucfirst($user->role) . '.');
        }

        return redirect()->route('login')->with('error', 'Username atau password salah.')->withInput();
    }

    // ==============================
    // LOGIN GUEST
    // ==============================
    public function guestLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth_guest.login', [
            'title' => 'Login Tamu'
        ]);
    }

    public function guestAuthenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->messages()->first())->withInput();
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Pastikan hanya tamu yang bisa login lewat route ini
            if ($user->role !== 'guest') {
                Auth::logout();
                return back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $user->last_login = Carbon::now();
            $user->save();

            Session::put('userData', $user->toArray());

            return redirect()->route('dashboard')->with('success', 'Login tamu berhasil!');
        }

        return back()->with('error', 'Username atau password salah.')->withInput();
    }

    // ==============================
    // LOGOUT
    // ==============================
    public function logout(Request $request)
    {
        $role = Auth::check() ? Auth::user()->role : null;

        Session::forget('userData');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'guest' || $role === 'jamaah') {
            return Redirect::route('guest.login')->with('success', 'Logout berhasil, sampai jumpa lagi!');
        }

        return Redirect::route('login')->with('success', 'Logout berhasil, sampai jumpa lagi!');
    }
}
