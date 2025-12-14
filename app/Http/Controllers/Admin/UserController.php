<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Manajemen User';

        $user = User::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($qq) use ($search) {
                    $qq->where('nama', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('role'), function ($q) use ($request) {
                $q->where('role', $request->role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // biar query string (search, role) tetap kebawa di pagination

        return view('admin.user.index', compact('user', 'title'));
    }

    public function create()
    {
        $title = 'Tambah User Baru';

        return view('admin.user.form', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // SESUAIKAN NAMA TABEL:
            // kalau tabel default Laravel → 'user'
            // kalau memang tabel kamu bernama 'user' → pakai 'user'
            'email'    => 'required|email|max:255|unique:user,email',
            'nama'     => 'required|string|max:255',
            'role'     => ['required', Rule::in(['super admin', 'admin', 'petugas', 'guest'])],
            'password' => 'required|min:6',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'email.unique' => 'Email sudah digunakan.',
            'foto.max'     => 'Ukuran file foto maksimal 2MB.',
        ]);

        // buang field yang tidak perlu
        $data = $request->except(['_token', 'foto', 'password_confirmation']);

        // hash password
        $data['password'] = Hash::make($request->password);

        // upload foto (jika ada)
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('user', 'public');
        } else {
            $data['foto'] = null;
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user  = User::findOrFail($id);
        $title = 'Detail User';

        return view('admin.user.show', compact('user', 'title'));
    }

    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $title = 'Edit User';

        return view('admin.user.form', compact('user', 'title'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            // SESUAIKAN NAMA TABEL seperti di store()
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('user', 'email')->ignore($user->id),
            ],
            'nama'  => 'required|string|max:255',
            'role'  => ['required', Rule::in(['super admin', 'admin', 'petugas', 'guest'])],
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        // Jangan overwrite password & foto dulu
        $data = $request->except(['_token', '_method', 'password', 'password_confirmation', 'foto']);

        // Jika password diisi → update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Jika ada foto baru → hapus lama & simpan baru
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('user', 'public');
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
