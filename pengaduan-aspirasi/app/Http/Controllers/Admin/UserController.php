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
    public function index()
    {
        $user = User::latest()->get();
        $title = 'Manajemen User';
        return view('admin.manajemen_user', compact('user', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:user,username|max:255',
            'nama' => 'required|string|max:255',
            'role' => ['required', Rule::in(['admin', 'guest'])],
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'foto.max' => 'Ukuran file foto maksimal 2MB.',
        ]);

        $data = $request->except(['_token', '_method', 'foto']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('user', 'public');
        } else {
            $data['foto'] = null;
        }

        User::create($data);

        return redirect()->route('admin.user.index')->with('success', 'user baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'username' => ['required', 'max:255', Rule::unique('user')->ignore($user->id)],
            'nama' => 'required|string|max:255',
            'role' => ['required', Rule::in(['admin', 'guest'])],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        $data = $request->except(['_token', '_method', 'password', 'foto']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('user', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'user berhasil dihapus.');
    }
}
