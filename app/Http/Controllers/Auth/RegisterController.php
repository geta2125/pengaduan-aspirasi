<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Warga;

class RegisterController extends Controller
{
    // ==============================
    // FORM REGISTER TAMU
    // ==============================
    public function guestRegister()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth_guest.register', [
            'title' => 'Registrasi Tamu'
        ]);
    }

    // ==============================
    // PROSES SIMPAN REGISTER TAMU
    // ==============================
    public function guestStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:user,username',
            'email' => 'required|email|unique:warga,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->messages()->first())->withInput();
        }

        // Simpan ke tabel users
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'guest',
            'foto' => null,
        ]);

        // Simpan atau update warga agar sinkron
        Warga::updateOrCreate(
            ['email' => $request->email],
            [
                'nama' => $request->nama,
                'email' => $request->email
            ]
        );

        // Login otomatis
        auth()->login($user);

        // Redirect ke form lengkapi data diri
        return redirect()->route('guest.warga.create')
            ->with('success', 'Registrasi berhasil! Silakan lengkapi data diri Anda.');
    }
}
