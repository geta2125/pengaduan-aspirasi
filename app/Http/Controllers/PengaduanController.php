<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengaduan;
use App\Models\Media;
use App\Models\Pengaduan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str; // Tambahkan ini untuk fungsi Str::afterLast
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    /**
     * Mengubah properti untuk menggunakan 'pengaduan_id' sebagai primary key
     * di Controller untuk operasi find/update berdasarkan ID.
     */
    protected $primaryKey = 'pengaduan_id';

    // ==============================
    // INDEX 📊
    // ==============================

    public function index(Request $request)
    {
        $title = 'Data Pengaduan';

        $query = Pengaduan::with(['warga', 'kategori', 'media']);

        // =====================================================
        // 🔐 FILTER ROLE GUEST (HANYA DATA MILIK USER LOGIN)
        // =====================================================
        if (Auth::check() && Auth::user()->role === 'guest') {
            $query->where('warga_id', Auth::user()->warga?->warga_id ?? 0);
        }

        // =====================================================
        // 🔍 FILTER STATUS
        // =====================================================
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // =====================================================
        // 🔎 SEARCH (JUDUL / NAMA WARGA)
        // =====================================================
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                    ->orWhereHas('warga', function ($q2) use ($request) {
                        $q2->where('nama', 'like', "%{$request->search}%");
                    });
            });
        }

        // =====================================================
        // 📄 PAGINATION
        // =====================================================
        $pengaduan = $query->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        // =====================================================
        // 🧠 TRANSFORM DATA UNTUK VIEW
        // =====================================================
        $pengaduan->getCollection()->transform(function ($item) {
            $tgl = Carbon::parse($item->created_at);

            return (object) [

                'pengaduan_id' => $item->pengaduan_id,
                'nomor_tiket'  => $item->nomor_tiket,
                'judul'        => $item->judul,
                'deskripsi'    => $item->deskripsi,
                'status'       => $item->status,

                // Relasi
                'pelapor'       => $item->warga->nama ?? 'Anonim',
                'nama_kategori' => $item->kategori->nama ?? '-',
                'lokasi_text'   => $item->lokasi_text ?? '-',
                'rt'            => $item->rt ?? '-',
                'rw'            => $item->rw ?? '-',

                // Format waktu
                'tgl_format_tabel' => $tgl->translatedFormat('d M Y'),
                'jam_format'       => $tgl->format('H:i'),
                'tgl_format_full'  => $tgl->translatedFormat('d F Y, H:i'),
                'statusClass'      => $this->getStatusClass($item->status),

                // Media
                'media' => $item->media->map(function ($mediaItem) {

                    if (!empty($mediaItem->caption)) {
                        $nameToShow = $mediaItem->caption;
                    } else {
                        $fullUniqueName = Str::afterLast($mediaItem->file_name, '/');
                        $nameParts = explode('_', $fullUniqueName, 2);
                        $nameToShow = count($nameParts) > 1 ? $nameParts[1] : $fullUniqueName;
                    }

                    return (object) [
                        'name'      => $nameToShow,
                        'url'       => asset('storage/' . $mediaItem->file_name),
                        'mime_type' => $mediaItem->mime_type,
                    ];
                })->all(),
            ];
        });

        return view('admin.pengaduan.index', compact('title', 'pengaduan'));
    }


    /**
     * Helper untuk menentukan class badge status
     */
    protected function getStatusClass($status)
    {
        $statusClass = [
            'pending' => 'badge-secondary',
            'proses' => 'badge-warning',
            'selesai' => 'badge-success'
        ];
        return $statusClass[$status] ?? 'badge-light';
    }

    // ==============================
    // CREATE, STORE, UPDATE, DESTROY (Logika di sini tidak perlu diulang)
    // ==============================

    public function create()
    {
        $title = "Tambah Pengaduan";
        $kategori = KategoriPengaduan::all();
        $warga = Warga::all();

        return view('admin.pengaduan.form', compact('kategori', 'warga', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // ... (validasi) ...
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_pengaduan,kategori_id',
            'deskripsi' => 'required|string',
            'warga_id' => 'required|exists:warga,warga_id',
            'lokasi_text' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx|max:10240',
        ]);

        $pengaduan = Pengaduan::create(array_merge($validated, [
            'nomor_tiket' => 'TIKET-' . time(),
            'status' => 'pending',
            'lokasi_text' => $request->lokasi_text,
            'rt' => $request->rt,
            'rw' => $request->rw,
        ]));

        $this->saveMultipleMedia($request, $pengaduan);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditambahkan!');
    }

    // ==============================
    // SHOW 👁️ (Pencarian berdasarkan pengaduan_id)
    // ==============================
    public function show($id)
    {
        $title = 'Detail Pengaduan';
        // Menggunakan where($this->primaryKey, $id)
        $pengaduan = Pengaduan::with(['kategori', 'media', 'warga'])
            ->where($this->primaryKey, $id)
            ->firstOrFail();

        return view('admin.pengaduan.show', compact('pengaduan', 'title'));
    }

    // ==============================
    // EDIT ✏️ (Pencarian berdasarkan pengaduan_id)
    // ==============================
    public function edit($id)
    {
        $title = 'Edit Pengaduan';
        $pengaduan = Pengaduan::with(['media', 'warga'])
            // Menggunakan where($this->primaryKey, $id)
            ->where($this->primaryKey, $id)
            ->firstOrFail();
        $kategori = KategoriPengaduan::all();
        $warga = Warga::all();

        return view('admin.pengaduan.form', compact('pengaduan', 'kategori', 'title', 'warga'));
    }

    // ==============================
    // UPDATE 🔄 (Pencarian berdasarkan pengaduan_id)
    // ==============================
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::where($this->primaryKey, $id)->firstOrFail(); // Menggunakan where($this->primaryKey, $id)

        $validated = $request->validate([
            // ... (validasi) ...
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_pengaduan,id',
            'deskripsi' => 'required|string',
            'warga_id' => 'required|exists:warga,warga_id',
            'lokasi_text' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx|max:10240',
        ]);

        $pengaduan->update($validated);
        $this->saveMultipleMedia($request, $pengaduan);

        return redirect()->route('pengaduan.index')->with('success', 'Data pengaduan berhasil diupdate!');
    }

    // ==============================
    // DESTROY 🗑️ (Pencarian berdasarkan pengaduan_id)
    // ==============================
    public function destroy($id)
    {
        $pengaduan = Pengaduan::with('media')
            ->where($this->primaryKey, $id) // Menggunakan where($this->primaryKey, $id)
            ->firstOrFail();

        foreach ($pengaduan->media as $media) {
            Storage::disk('public')->delete($media->file_name);
            $media->delete();
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus!');
    }

    // ==============================
    // UPDATE STATUS 🟢 (Pencarian berdasarkan pengaduan_id)
    // ==============================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pengaduan = Pengaduan::where($this->primaryKey, $id)->firstOrFail(); // Menggunakan where($this->primaryKey, $id)
        $pengaduan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }

    // ==============================
    // MULTIPLE MEDIA UPLOAD 📎
    // ==============================
    protected function saveMultipleMedia(Request $request, Pengaduan $pengaduan)
    {
        if ($request->hasFile('lampiran')) {
            $refId = $pengaduan->{$this->primaryKey};

            foreach ($request->file('lampiran') as $file) {
                if (!$file->isValid()) {
                    continue;
                }

                $originalName = $file->getClientOriginalName(); // <-- Simpan nama asli di variabel ini
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension; // <-- Nama unik untuk penyimpanan

                $path = $file->storeAs('pengaduan_lampiran', $filename, 'public');

                Media::create([
                    'ref_table' => 'pengaduan',
                    'ref_id' => $refId,
                    'file_name' => $path, // Menyimpan path unik server
                    'mime_type' => $file->getClientMimeType(),
                    'sort_order' => 0,
                    'caption' => $originalName // <-- Nama ASLI disimpan di kolom CAPTION
                ]);
            }
        }
    }
}
