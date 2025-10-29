<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\DaftarAkun;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\BukuBesar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    // --- Form Ubah Password ---
    // Form Edit Profile
    public function Profile()
    {
        $user = Auth::user();
        $title = 'Edit Profile';
        return view('dashboard.profile', compact('user', 'title'));
    }

    public function index()
    {
        $title = 'Dashboard';

        $user = Auth::user();

        if ($user->role == 'admin') {
            return view('admin.dashboard', compact(
                'title',
                'user'
            ));
        } else {
            return view('guest.dashboard', compact(
                'title',
                'user'
            ));
        }

    }

    /** ============================
     *  UPDATE PROFIL
     *  ============================ */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengguna,username,' . $user->id,
        ]);

        // Ambil data yang akan diupdate
        $data = $request->only('nama', 'username');

        // Cek apakah ada perubahan
        if ($user->nama !== $data['nama'] || $user->username !== $data['username']) {
            $user->update($data);
            return back()->with('success', 'Profil berhasil diperbarui.');
        }

        // Jika tidak ada perubahan
        return back()->with('info', 'Tidak ada perubahan data.');
    }


    /** ============================
     *  UPDATE PASSWORD
     *  ============================ */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    /** ============================
     *  UPDATE FOTO PROFIL
     *  ============================ */
    public function updateFoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru ke folder 'foto_user' di storage/public
            $data['foto'] = $request->file('foto')->store('foto_user', 'public');
        }

        // Update data foto ke user


        if ($user->update($data)) {
            return back()->with('success', 'Foto profil berhasil diperbarui.');
        } else {
            return back()->with('error', 'Foto tidak berhasil diperbarui');
        }
    }


}
