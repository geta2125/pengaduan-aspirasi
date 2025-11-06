<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::with(['warga', 'kategori'])->latest()->get();
        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        $kategori = KategoriPengaduan::all();
        return view('admin.pengaduan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kategori_id' => 'required',
        ]);

        $nomor_tiket = 'TIKET-' . strtoupper(uniqid());

        Pengaduan::create([
            'nomor_tiket' => $nomor_tiket,
            'warga_id' => auth()->user()->id ?? 1, // sesuaikan dengan sistem loginmu
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi_text' => $request->lokasi_text,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'status' => 'baru',
        ]);

        return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil ditambahkan');
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['warga', 'kategori', 'tindak_lanjut', 'penilaian'])->findOrFail($id);
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $kategori = KategoriPengaduan::all();
        return view('admin.pengaduan.edit', compact('pengaduan', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'kategori_id' => 'required',
            'status' => 'required',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update($request->all());

        return redirect()->route('admin.pengaduan.index')->with('success', 'Data pengaduan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')->with('success', 'Data pengaduan berhasil dihapus');
    }

    // Tambahan untuk daftar baru & semua pengaduan
    public function pengaduanBaru()
    {
        $pengaduan = Pengaduan::where('status', 'baru')->latest()->get();
        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    public function semuaPengaduan()
    {
        $pengaduan = Pengaduan::latest()->get();
        return view('admin.pengaduan.index', compact('pengaduan'));
    }

    // Form & proses tindak lanjut
    public function tindaklanjutForm($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.tindaklanjut', compact('pengaduan'));
    }

    public function tindaklanjutStore(Request $request, $id)
    {
        // nanti bisa ditambahkan simpan ke tabel tindak_lanjut
    }
}
