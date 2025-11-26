<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Media;
use App\Models\Pengaduan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // ==============================
    // INDEX - Halaman daftar pengaduan
    // ==============================
    public function index(Request $request)
    {
        $title = 'Data Pengaduan';

        // Mulai query
        $query = Pengaduan::with(['warga', 'kategori', 'media']);

        // Filter status jika ada
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Search berdasarkan judul atau nama pelapor
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                    ->orWhereHas('warga', function ($q2) use ($request) {
                        $q2->where('nama', 'like', "%{$request->search}%");
                    });
            });
        }

        // Pagination 10 data per halaman
        $pengaduan = $query->latest()->paginate(10)->withQueryString();

        // Mapping data untuk menambahkan badge class
        $pengaduan->getCollection()->transform(function ($item) {
            $statusClass = [
                'pending' => 'badge-light',
                'proses' => 'badge-warning',
                'selesai' => 'badge-success'
            ];

            return (object) [
                'id' => $item->id,
                'pengaduan_id' => $item->pengaduan_id,
                'judul' => $item->judul,
                'pelapor' => $item->warga->nama ?? 'Anonim',
                'kategori' => $item->kategori->nama ?? '-',
                'tanggal' => $item->created_at->format('d/m/Y'),
                'tanggal_full' => $item->created_at->format('d F Y, H:i'),
                'status' => $item->status,
                'statusClass' => $statusClass[strtolower($item->status)] ?? 'badge-secondary',
                'lokasi_text' => $item->lokasi_text ?? '-',
                'rt' => $item->rt ?? '-',
                'rw' => $item->rw ?? '-',
                'deskripsi' => $item->deskripsi,
                'media' => $item->media?->file_url ?? null
            ];
        });

        return view('admin.pengaduan.index', compact('pengaduan', 'title'));
    }

    // ==============================
    // CREATE - Form tambah pengaduan
    // ==============================
    public function create()
    {
        $title = "Tambah Pengaduan";
        $kategori = KategoriPengaduan::all();
        $warga = Warga::all(); // TAMBAHKAN

        return view('admin.pengaduan.form', compact('kategori', 'warga', 'title'));
    }


    // ==============================
    // STORE - Simpan pengaduan baru
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
            'warga_id' => 'nullable|integer',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx|max:5120',
        ]);

        // Buat record pengaduan
        $pengaduan = Pengaduan::create([
            'nomor_tiket' => 'TIKET-' . time(),
            'warga_id' => $request->warga_id,
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi_text' => $request->lokasi_text,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'status' => 'pending',
        ]);

        // Upload lampiran
        $this->handleLampiran($request, $pengaduan);

        return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil ditambahkan!');
    }

    // ==============================
    // SHOW - Detail pengaduan
    // ==============================
    public function show($id)
    {
        $title = 'Detail Pengaduan';
        $pengaduan = Pengaduan::with(['kategori', 'media', 'warga'])->findOrFail($id);

        return view('admin.pengaduan.show', compact('pengaduan', 'title'));
    }

    // ==============================
    // EDIT - Form edit pengaduan
    // ==============================
    public function edit($id)
    {
        $title = 'Edit Pengaduan';
        $pengaduan = Pengaduan::with(['media', 'warga'])->findOrFail($id);
        $kategori = KategoriPengaduan::all();
        $warga = Warga::all(); // TAMBAHKAN

        return view('admin.pengaduan.form', compact('pengaduan', 'kategori', 'title', 'warga'));
    }

    // ==============================
    // UPDATE - Proses update data
    // ==============================
    public function update(Request $request, $id)
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

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->update([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'deskripsi' => $request->deskripsi,
            'lokasi_text' => $request->lokasi_text,
            'rt' => $request->rt,
            'rw' => $request->rw,
        ]);

        // Upload lampiran baru jika ada
        $this->handleLampiran($request, $pengaduan);

        return redirect()->route('admin.pengaduan.index')->with('success', 'Data pengaduan berhasil diupdate!');
    }

    // ==============================
    // DESTROY - Hapus pengaduan
    // ==============================
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hapus lampiran juga
        $media = Media::where('ref_table', 'pengaduan')
            ->where('ref_id', $pengaduan->pengaduan_id)
            ->first();

        if ($media) {
            Storage::disk('public')->delete($media->file_url);
            $media->delete();
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')->with('success', 'Pengaduan berhasil dihapus!');
    }

    // ==============================
    // UPDATE STATUS PENGADUAN (Admin)
    // ==============================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        Pengaduan::where('pengaduan_id', $id)->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }

    // ==============================
    // HANDLE LAMPIRAN
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
}
