<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;

class WargaController extends Controller
{
    // ==============================
    // FORM LENGKAPI DATA DIRI
    // ==============================
    public function create()
    {
        $user = auth()->user();

        // Ambil warga berdasarkan nama user
        $warga = Warga::where('nama', $user->nama)->first();

        if (!$warga) {
            // Buat baru, email bisa kosong atau diisi sesuai kebutuhan
            $warga = Warga::create([
                'nama' => $user->nama,
                'email' => '', // bisa diisi manual nanti
            ]);
        }

        return view('auth_guest.warga_form', [
            'title' => 'Lengkapi Data Diri',
            'warga' => $warga
        ]);
    }



    // ==============================
    // UPDATE DATA WARGA
    // ==============================
    public function update(Request $request)
    {
        $user = auth()->user();
        $warga = Warga::where('nama', $user->nama)->firstOrFail();

        $request->validate([
            'no_ktp' => 'required|unique:warga,no_ktp,' . $warga->warga_id . ',warga_id',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'telp' => 'required',
        ]);        

        $warga->update([
            'no_ktp' => $warga->no_ktp ?: $request->no_ktp,
            'jenis_kelamin' => $warga->jenis_kelamin ?: $request->jenis_kelamin,
            'agama' => $warga->agama ?: $request->agama,
            'pekerjaan' => $warga->pekerjaan ?: $request->pekerjaan,
            'telp' => $warga->telp ?: $request->telp,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data diri berhasil diperbarui!');
    }



}
