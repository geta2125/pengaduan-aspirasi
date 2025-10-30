<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Penilaian;

class PenilaianController extends Controller
{

    public function index()
    {
        $title = 'Pengaduan';

        $pengaduan = Pengaduan::with(['warga', 'kategori', 'media', 'tindak_lanjut'])
            ->where('status', 'selesai')
            ->latest()
            ->get();

        return view('guest.penilaian.pengaduan', compact('pengaduan', 'title'));
    }

    public function pengaduan(Request $request)
    {
        $title = 'Pengaduan';

        $pengaduan = Pengaduan::with(['warga', 'kategori', 'media', 'tindak_lanjut'])
            ->where('status', 'selesai')
            ->latest()
            ->get();

        return view('guest.penilaian.pengaduan', compact('pengaduan', 'title'));
    }

    public function create($pengaduan_id)
    {
        $title = 'Pengaduan';

        $pengaduan = Pengaduan::findOrFail($pengaduan_id);
        return view('guest.penilaian.form', compact('pengaduan','title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,pengaduan_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Penilaian::create([
            'pengaduan_id' => $request->pengaduan_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('guest.penilaian.index')->with('success', 'Penilaian berhasil ditambahkan!');
    }
}
