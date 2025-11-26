<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Warga;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $title = "Data Warga";

        $search = $request->search;
        $gender = $request->gender;

        $query = Warga::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('username', 'like', "%$search%");
                    });
            });
        }

        if ($gender) {
            $query->where('jenis_kelamin', $gender);
        }

        $warga = $query->paginate(10);
        $warga->appends($request->all());

        return view('admin.warga.index', compact('title', 'warga'));
    }

    public function create()
    {
        return view('admin.warga.form', [
            'title' => 'Tambah Data Warga',
            'warga' => null, // penting agar form tidak error
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // USER
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:user,username',
            'password' => 'required|string|min:6|confirmed',

            // WARGA
            'email' => 'required|email|unique:warga,email',
            'no_ktp' => 'required|numeric|digits:16|unique:warga,no_ktp',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'telp' => 'required|numeric',
        ]);

        // Buat USER
        $user = User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'guest',
            'foto' => null,
        ]);

        // Buat WARGA
        Warga::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_ktp' => $request->no_ktp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'telp' => $request->telp,
        ]);

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $warga = Warga::with('user')->findOrFail($id);

        return view('admin.warga.form', [
            'title' => 'Edit Data Warga',
            'warga' => $warga,
        ]);
    }

    public function update(Request $request, $id)
    {
        $warga = Warga::with('user')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:warga,email,' . $id . ',warga_id',
            'no_ktp' => 'required|numeric|digits:16|unique:warga,no_ktp,' . $id . ',warga_id',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'telp' => 'required|numeric',

            // Jika edit username, validasi unik kecuali username dia sendiri
            'username' => 'nullable|string|max:50|unique:user,username,'
                . ($warga->user->id ?? 'NULL'),
        ]);

        // Update tabel Warga
        $warga->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_ktp' => $request->no_ktp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'pekerjaan' => $request->pekerjaan,
            'telp' => $request->telp,
        ]);

        // Update tabel User
        if ($warga->user) {
            $warga->user->update([
                'nama' => $request->nama,
                'username' => $request->username ?? $warga->user->username,
            ]);
        }

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga & user berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $warga = Warga::with('user')->findOrFail($id);

        // Hapus User
        if ($warga->user) {
            $warga->user->delete();
        }

        // Hapus Warga
        $warga->delete();

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data warga & user berhasil dihapus.');
    }

    public function show($id)
    {
        $warga = Warga::with('user')->findOrFail($id);

        return view('admin.warga.show', [
            'title' => 'Detail Data Warga',
            'warga' => $warga,
            'user' => $warga->user,
        ]);
    }
}
