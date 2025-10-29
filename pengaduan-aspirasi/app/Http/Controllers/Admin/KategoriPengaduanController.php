<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class KategoriPengaduanController extends Controller
{
    public function index()
    {
        $kategori = KategoriPengaduan::all();
        $title = 'Daftar Kategori Pengaduan';
        return view('admin.kategori.index', compact('kategori', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Kategori Pengaduan';
        return view('admin.kategori.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sla_hari' => 'required|integer',
            'prioritas' => 'required|string|max:50'
        ]);

        KategoriPengaduan::create([
            'nama' => $request->nama,
            'sla_hari' => $request->sla_hari,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->route('admin.kategori-pengaduan.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show($id)
    {
        $title = 'Detail Kategori Pengaduan';
        $kategori = KategoriPengaduan::findOrFail($id);
        return view('admin.kategori.show', compact('kategori', 'title'));
    }

    public function edit($id)
    {
        $title = 'Edit Kategori Pengaduan';
        $kategori = KategoriPengaduan::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori', 'title'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sla_hari' => 'required|integer',
            'prioritas' => 'required|string|max:50'
        ]);

        $kategori = KategoriPengaduan::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama,
            'sla_hari' => $request->sla_hari,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->route('admin.kategori-pengaduan.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = KategoriPengaduan::findOrFail($id);
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

}
