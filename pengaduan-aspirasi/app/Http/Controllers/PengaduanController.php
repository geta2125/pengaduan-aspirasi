<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;
use App\Models\Media;
use App\Models\Tindak_Lanjut;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // ==============================
    // Halaman ajukan / edit pengaduan
    // ==============================
    public function ajukan($pengaduan_id = null)
    {
        $title = "Formulir Pengaduan";
        $kategori = KategoriPengaduan::all();

        $pengaduan = $pengaduan_id
            ? Pengaduan::with('media')->findOrFail($pengaduan_id)
            : null;

        return view('guest.pengaduan.form', compact('kategori', 'pengaduan','title'));
    }

    // ==============================
    // Halaman riwayat pengaduan
    // ==============================
    public function riwayat(Request $request)
    {
        $title = "Riwayat Pengaduan";
        $pengaduan = Pengaduan::with(['warga', 'kategori', 'media'])
            ->where('warga_id', auth()->user()->warga->warga_id ?? 0)
            ->latest()->get();

        return view('guest.pengaduan.index', compact('pengaduan','title'));
    }

    // ==============================
    // Halaman detail pengaduan
    // ==============================
    public function show($id)
    {
        $pengaduan = Pengaduan::with('kategori')->findOrFail($id);
        return view('guest.pengaduan.show', compact('pengaduan'));
    }

    // ==============================
    // Store pengaduan
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'deskripsi' => 'required|string',
            'lokasi_text' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx|max:5120',
        ]);

        $wargaId = auth()->user()->warga->warga_id ?? null;
        if (!$wargaId) {
            return redirect()->route('warga.create')->with('error', 'Lengkapi data diri terlebih dahulu!');
        }

        $pengaduan = Pengaduan::create([
            'nomor_tiket' => 'TIKET-' . time(),
            'warga_id' => $wargaId,
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi_text' => $request->lokasi_text,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'status' => 'pending',
        ]);

        // Simpan lampiran
        $this->handleLampiran($request, $pengaduan);

        return redirect()->route('guest.pengaduan.riwayat')->with('success', 'Pengaduan berhasil diajukan!');
    }

    // ==============================
    // Update pengaduan
    // ==============================
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'deskripsi' => 'required|string',
            'lokasi_text' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx|max:5120',
        ]);

        $pengaduan->update($request->only('judul', 'kategori_id', 'deskripsi', 'lokasi_text', 'rt', 'rw'));

        // Update lampiran
        $this->handleLampiran($request, $pengaduan);

        return redirect()->route('guest.pengaduan.riwayat')->with('success', 'Pengaduan berhasil diperbarui!');
    }

    // ==============================
    // Fungsi bantu handle lampiran
    // ==============================
    protected function handleLampiran(Request $request, Pengaduan $pengaduan)
    {
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $path = $file->store('pengaduan_lampiran', 'public');

            $media = Media::where('ref_table', 'pengaduan')
                ->where('ref_id', $pengaduan->pengaduan_id)
                ->first();

            if ($media) {
                Storage::disk('public')->delete($media->file_url);
                $media->update([
                    'file_url' => $path,
                    'mime_type' => $file->getClientMimeType(),
                ]);
            } else {
                Media::create([
                    'ref_table' => 'pengaduan',
                    'ref_id' => $pengaduan->pengaduan_id,
                    'file_url' => $path,
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }
    }

    // ==============================
    // ADMIN - Tampilkan semua pengaduan baru
    // ==============================
    public function pengaduanBaru(Request $request)
    {
        $pengaduan = Pengaduan::with(['warga', 'kategori', 'media'])
            ->where('status', 'pending') // hanya pengaduan baru
            ->latest()->get();

        $title = 'Pengaduan Baru';
        return view('admin.pengaduan.baru', compact('pengaduan', 'title'));
    }

    // ==============================
    // ADMIN - Update status pengaduan
    // ==============================
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pengaduan->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui!');
    }

    // ==============================
    // ADMIN - Tampilkan semua pengaduan
    // ==============================
    public function semuaPengaduan(Request $request)
    {
        $title = 'Pengaduan';

        $pengaduan = Pengaduan::with(['warga', 'kategori', 'media', 'tindak_lanjut'])
            ->latest()
            ->get();

        return view('admin.pengaduan.semua', compact('pengaduan', 'title'));
    }

    // Form tindak lanjut
    public function tindaklanjutForm($id)
    {
        $title = 'Form Tindak Lanjut';
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.tindaklanjut', compact('pengaduan', 'title'));
    }

    // Simpan tindak lanjut
    public function tindaklanjutStore(Request $request, $id)
    {
        $request->validate([
            'petugas' => 'nullable|string|max:255',
            'aksi' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        // Simpan tindak lanjut
        Tindak_Lanjut::create([
            'pengaduan_id' => $id,
            'petugas' => $request->petugas,
            'aksi' => $request->aksi,
            'catatan' => $request->catatan,
        ]);

        // Update status pengaduan berdasarkan aksi
        $pengaduan = Pengaduan::findOrFail($id);

        switch ($request->aksi) {
            case 'Diterima':
            case 'Sedang Diproses':
            case 'Ditugaskan Petugas':
                $pengaduan->status = 'proses';
                break;
            case 'Selesai':
                $pengaduan->status = 'selesai';
                break;
        }

        $pengaduan->save();

        return redirect()->route('admin.pengaduan.semua')->with('success', 'Tindak lanjut berhasil ditambahkan dan status pengaduan diperbarui.');
    }
}
