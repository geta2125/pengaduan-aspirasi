<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Tindak_Lanjut;
use Illuminate\Support\Facades\Auth; // Wajib diimpor
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class TindakLanjutController extends Controller
{
    // ==============================
    // INDEX
    // ==============================
    public function index(Request $request): View
    {
        $title = 'Daftar Tindak Lanjut';

        // Nilai-nilai filter dari request
        $search = $request->input('search');
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        // Mulai query
        $query = Tindak_Lanjut::with(['pengaduan.warga'])
            ->latest();

        // Filter Status
        if ($status) {
            $query->where('aksi', $status);
        }

        // Filter Search (Judul Pengaduan atau Nama Pelapor)
        if ($search) {
            $query->whereHas('pengaduan', function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhereHas('warga', function ($qWarga) use ($search) {
                        $qWarga->where('nama', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter Tanggal Tindak Lanjut (From)
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        // Filter Tanggal Tindak Lanjut (To)
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Ambil data dengan pagination (misalnya 10 data per halaman)
        $tindaklanjut = $query->paginate(10)->withQueryString();

        return view('admin.tindaklanjut.index', compact('tindaklanjut', 'title'));
    }

    // ==============================
    // DETAIL
    // ==============================
    public function show($id): View
    {
        $title = 'Detail Tindak Lanjut';
        $tindaklanjut = Tindak_Lanjut::with([
            'pengaduan.kategori',
            'pengaduan.media',
            'pengaduan.warga',
            'media', // 🔹 TAMBAH INI
        ])->findOrFail($id);

        return view('admin.tindaklanjut.show', compact('tindaklanjut', 'title'));
    }

    // ==============================
    // MULTIPLE MEDIA UPLOAD 📎 (Tindak Lanjut)
    // ==============================
    protected function saveMultipleMedia(Request $request, Tindak_Lanjut $tindaklanjut)
    {
        if ($request->hasFile('lampiran')) {
            $refId = $tindaklanjut->tindak_id; // primary key default

            // mulai urutan setelah yang terakhir (kalau sudah ada media)
            $lastOrder = $tindaklanjut->media()->max('sort_order') ?? 0;

            foreach ($request->file('lampiran') as $index => $file) {
                if (!$file->isValid()) {
                    continue;
    }

                $originalName = $file->getClientOriginalName(); // nama asli file
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension; // nama unik di server

                // simpan di folder khusus tindak lanjut
                $path = $file->storeAs('tindak_lanjut_lampiran', $filename, 'public');

                Media::create([
                    'ref_table'  => 'tindak_lanjut',
                    'ref_id'     => $refId,
                    'file_name'  => $path,                    // path unik untuk storage
                    'mime_type'  => $file->getClientMimeType(),
                    'sort_order' => $lastOrder + $index + 1,
                    'caption'    => $originalName,            // simpan NAMA ASLI di caption (sama seperti pengaduan)
                ]);
            }
        }
    }


    // ==============================
    // FORM TAMBAH (KHUSUS DARI ID PENGADUAN)
    // ==============================
    public function create($pengaduan_id): View
    {
        $title = 'Form Tindak Lanjut';
        $pengaduan = Pengaduan::with('warga')->findOrFail($pengaduan_id);

        return view('admin.tindaklanjut.create', compact('pengaduan', 'title'));
    }

    // ==============================
    // SIMPAN DATA (STORE)
    // ==============================
    public function store(Request $request, $id): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Akses ditolak. Anda harus login sebagai petugas.');
        }

        $request->validate([
            'aksi' => 'required|string|max:255',
            'catatan' => 'nullable|string',

            // 🔹 tambahkan validasi multiple file (mirip pengaduan)
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx|max:10240',
        ]);

        $petugasName = Auth::user()->nama;

        // Simpan tindak lanjut dulu
        $tindaklanjut = Tindak_Lanjut::create([
            'pengaduan_id' => $id,
            'petugas' => $petugasName,
            'aksi' => $request->aksi,
            'catatan' => $request->catatan,
        ]);

        // 🔹 simpan multiple media (kayak pengaduan)
        $this->saveMultipleMedia($request, $tindaklanjut);

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

        return redirect()->route('tindaklanjut.index')->with('success', 'Tindak lanjut berhasil ditambahkan.');
    }


    // ==============================
    // FORM EDIT
    // ==============================
    public function edit($id): View
    {
        $title = 'Edit Tindak Lanjut';
        $tindaklanjut = Tindak_Lanjut::with('pengaduan')->findOrFail($id);

        return view('admin.tindaklanjut.edit', compact('tindaklanjut', 'title'));
    }

    // ==============================
    // UPDATE DATA
    // ==============================
    public function update(Request $request, $id): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Akses ditolak. Anda harus login sebagai petugas.');
        }

        $request->validate([
            'aksi' => 'required|string|max:255',
            'catatan' => 'nullable|string',

            // 🔹 validasi multiple file baru
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx|max:10240',
        ]);

        $tindaklanjut = Tindak_Lanjut::findOrFail($id);
        $petugasName = Auth::user()->nama;

        $tindaklanjut->update([
            'petugas' => $petugasName,
            'aksi' => $request->aksi,
            'catatan' => $request->catatan,
        ]);

        // 🔹 simpan (tambahkan) file-file baru
        $this->saveMultipleMedia($request, $tindaklanjut);

        // update status pengaduan juga
        $pengaduan = $tindaklanjut->pengaduan;
        $pengaduan->status = ($request->aksi === 'Selesai') ? 'selesai' : 'proses';
        $pengaduan->save();

        return redirect()->route('tindaklanjut.index')->with('success', 'Tindak lanjut berhasil diperbarui.');
    }


    // ==============================
    // HAPUS DATA
    // ==============================
    public function destroy($id): JsonResponse
    {
        $tindaklanjut = Tindak_Lanjut::with('media')->findOrFail($id);

        // hapus semua media terkait
        foreach ($tindaklanjut->media as $media) {
            if ($media->file_name && Storage::disk('public')->exists($media->file_name)) {
                Storage::disk('public')->delete($media->file_name);
            }
            $media->delete();
        }

        $tindaklanjut->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tindak Lanjut berhasil dihapus'
        ]);
    }
}
