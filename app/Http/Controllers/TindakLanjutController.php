<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tindak_Lanjut;

class TindakLanjutController extends Controller
{
    // ==============================
    // INDEX
    // ==============================
    public function index()
    {
        $title = 'Daftar Tindak Lanjut';

        $tindaklanjut = Tindak_Lanjut::with(['pengaduan.warga'])
            ->latest()
            ->get();

        return view('admin.tindaklanjut.index', compact('tindaklanjut', 'title'));
    }

    // ==============================
    // DETAIL
    // ==============================
    public function show($id)
    {
        $title = 'Detail Tindak Lanjut';
        $tindaklanjut = Tindak_Lanjut::with(['pengaduan.kategori', 'pengaduan.media', 'pengaduan.warga'])
            ->findOrFail($id);

        return view('admin.tindaklanjut.show', compact('tindaklanjut', 'title'));
    }

    // ==============================
    // FORM TAMBAH (KHUSUS DARI ID PENGADUAN)
    // ==============================
    public function create($pengaduan_id)
    {
        $title = 'Form Tindak Lanjut';
        $pengaduan = Pengaduan::with('warga')->findOrFail($pengaduan_id);

        return view('admin.tindaklanjut.create', compact('pengaduan', 'title'));
    }

    // ==============================
    // SIMPAN DATA
    // ==============================
    public function store(Request $request, $id)
    {
        $request->validate([
            'petugas' => 'nullable|string|max:255',
            'aksi' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        // Simpan ke tabel tindak lanjut
        Tindak_Lanjut::create([
            'pengaduan_id' => $id,
            'petugas' => $request->petugas,
            'aksi' => $request->aksi,
            'catatan' => $request->catatan,
        ]);

        // Update status pengaduan
        $pengaduan = Pengaduan::findOrFail($id);
        switch ($request->aksi) {
            case 'Selesai':
                $pengaduan->status = 'selesai';
                break;
            default:
                $pengaduan->status = 'proses';
                break;
        }
        $pengaduan->save();

        return redirect()->route('admin.tindaklanjut.index')->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }

    // ==============================
    // FORM EDIT
    // ==============================
    public function edit($id)
    {
        $title = 'Edit Tindak Lanjut';
        $tindaklanjut = Tindak_Lanjut::with('pengaduan')->findOrFail($id);

        return view('admin.tindaklanjut.edit', compact('tindaklanjut', 'title'));
    }

    // ==============================
    // UPDATE DATA
    // ==============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'petugas' => 'nullable|string|max:255',
            'aksi' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $tindaklanjut = Tindak_Lanjut::findOrFail($id);
        $tindaklanjut->update([
            'petugas' => $request->petugas,
            'aksi' => $request->aksi,
            'catatan' => $request->catatan,
        ]);

        // update status pengaduan juga
        $pengaduan = $tindaklanjut->pengaduan;
        $pengaduan->status = ($request->aksi === 'Selesai') ? 'selesai' : 'proses';
        $pengaduan->save();

        return redirect()->route('admin.tindaklanjut.index')->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

    // ==============================
    // HAPUS DATA
    // ==============================
   public function destroy($id)
    {
        $tindaklanjut = Tindak_Lanjut::findOrFail($id);
        $tindaklanjut->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tindak Lanjut berhasil dihapus'
        ]);
    }
}
