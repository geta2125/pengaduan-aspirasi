<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Penilaian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Pengaduan Selesai (Menunggu/Sudah Dinilai)';

        // Ambil pengaduan yang statusnya "Selesai" + relasi yang dipakai di view
        $query = Pengaduan::with([
            'warga',
            'kategori',
            'media',
            'penilaian',
            'tindak_lanjut.media', // 🔹 tambahkan eager load media tindak lanjut
        ])
            ->where('status', 'Selesai') // status di tabel pengaduan
            ->whereHas('tindak_lanjut', function ($q) {
                $q->where('aksi', 'Selesai');   // kolom aksi di tabel tindak_lanjut
            });

        // --- Filtering & Searching ---
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->search}%")
                    ->orWhere('nomor_tiket', 'like', "%{$request->search}%")
                    ->orWhereHas('warga', function ($q2) use ($request) {
                        $q2->where('nama', 'like', "%{$request->search}%");
                    });
            });
        }

        if (Auth::check() && Auth::user()->role === 'guest') {
            $query->where('warga_id', Auth::user()->warga?->warga_id ?? 0);
        }

        // Urutkan berdasarkan waktu selesai (updated_at) & paginate
        $pengaduan = $query->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        // --- Mapping data untuk kebutuhan tampilan (View) ---
        $pengaduan->getCollection()->transform(function ($item) {
            $tgl = Carbon::parse($item->updated_at);

            // ====== MEDIA PENGADUAN ======
            $mediaList = $item->media->map(function ($mediaItem) {
                $url = asset('storage/' . $mediaItem->file_name);

                if (!empty($mediaItem->caption)) {
                    $nameToShow = $mediaItem->caption;
                } else {
                    $fullUniqueName = Str::afterLast($mediaItem->file_name, '/');
                    $nameParts = explode('_', $fullUniqueName, 2);
                    $nameToShow = count($nameParts) > 1 ? $nameParts[1] : $fullUniqueName;
                    $nameToShow = Str::limit($nameToShow, 40, '...');
                }

                return (object) [
                    'name'      => $nameToShow,
                    'url'       => $url,
                    'mime_type' => $mediaItem->mime_type,
                ];
            })->all();

            // ====== TINDAK LANJUT / CATATAN (PLUS MEDIA TINDAK LANJUT) ======
            $tindakLanjutList = $item->tindak_lanjut
                ? $item->tindak_lanjut->map(function ($tl) {

                    // 🔹 media untuk tindak lanjut ini
                    $mediaTlList = $tl->media
                        ? $tl->media->map(function ($mediaItem) {
                            $url = asset('storage/' . $mediaItem->file_name);

                            if (!empty($mediaItem->caption)) {
                                $nameToShow = $mediaItem->caption;
                            } else {
                                $fullUniqueName = Str::afterLast($mediaItem->file_name, '/');
                                $nameParts = explode('_', $fullUniqueName, 2);
                                $nameToShow = count($nameParts) > 1 ? $nameParts[1] : $fullUniqueName;
                                $nameToShow = Str::limit($nameToShow, 40, '...');
                            }

                            return (object) [
                                'name'      => $nameToShow,
                                'url'       => $url,
                                'mime_type' => $mediaItem->mime_type,
                            ];
                        })->all()
                        : [];

                    return (object) [
                        // di tabel tindak_lanjut petugas adalah STRING, bukan relasi
                        'petugas'        => $tl->petugas ?? '-',
                        'catatan'        => $tl->catatan ?? 'Tidak ada catatan',
                        'created_at'     => $tl->created_at,
                        'created_at_iso' => optional($tl->created_at)->toIso8601String(),
                        'media'          => $mediaTlList,   // 🔹 ini yang dipakai di JS (tl.media)
                    ];
                })->all()
                : [];

            $jumlahTindakLanjut = count($tindakLanjutList);
            $lastcatatanSnippet = $jumlahTindakLanjut
                ? Str::limit(end($tindakLanjutList)->catatan, 40, '...')
                : null;

            return (object) [
                'pengaduan_id' => $item->pengaduan_id,
                'nomor_tiket'  => $item->nomor_tiket,

                'judul'     => $item->judul,
                'deskripsi' => $item->deskripsi,
                'status'    => $item->status,

                'penilaian' => $item->penilaian ? (object) [
                    'penilaian_id' => $item->penilaian->penilaian_id,
                    'rating'       => $item->penilaian->rating,
                    'komentar'     => $item->penilaian->komentar,
                    'created_at'   => $item->penilaian->created_at,
                ] : null,

                'pelapor'     => $item->warga->nama ?? 'Anonim',
                'nama'        => $item->kategori->nama ?? '-',
                'lokasi_text' => $item->lokasi_text ?? '-',
                'rt'          => $item->rt ?? '-',
                'rw'          => $item->rw ?? '-',

                'tgl_format_tabel' => $tgl->translatedFormat('d M Y'),
                'jam_format'       => $tgl->format('H:i'),
                'tgl_format_full'  => $tgl->translatedFormat('d F Y, H:i'),
                'statusClass'      => $this->getStatusClass($item->status),

                'media'            => $mediaList,

                // ====== FIELD TAMBAHAN UNTUK TINDAK LANJUT ======
                'tindak_lanjut'        => $tindakLanjutList,
                'jumlah_tindak_lanjut' => $jumlahTindakLanjut,
                'last_catatan_snippet' => $lastcatatanSnippet,
            ];
        });

        return view('admin.penilaian.index', compact('title', 'pengaduan'));
    }


    /**
     * Simpan penilaian baru ke database (Create).
     * Route: POST /admin/penilaian
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduan,pengaduan_id',
            'rating'       => 'required|integer|min:1|max:5',
            'komentar'     => 'nullable|string',
        ]);

        // Cek apakah penilaian untuk pengaduan ini sudah ada
        $existing = Penilaian::where('pengaduan_id', $data['pengaduan_id'])->first();
        if ($existing) {
            throw ValidationException::withMessages([
                'pengaduan_id' => 'Pengaduan ini sudah memiliki penilaian, silakan ubah penilaian jika ingin mengedit.',
            ]);
        }

        Penilaian::create($data);

        return redirect()
            ->back()
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    /**
     * Tampilkan detail satu penilaian (READ detail)
     * Route: GET /admin/penilaian/{penilaian}
     */
    public function show(Penilaian $penilaian)
    {
        // Kalau mau, bisa buat view khusus, misal: admin.penilaian.show
        return view('admin.penilaian.show', [
            'title'     => 'Detail Penilaian',
            'penilaian' => $penilaian,
        ]);
    }

    /**
     * Update penilaian (UPDATE)
     * Route: PUT /admin/penilaian/{penilaian}
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        $data = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $penilaian->update($data);

        return redirect()
            ->back()
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    /**
     * Hapus penilaian (DELETE)
     * Route: DELETE /admin/penilaian/{penilaian}
     */
    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();

        return redirect()
            ->back()
            ->with('success', 'Penilaian berhasil dihapus.');
    }


    /**
     * Helper function untuk menentukan class badge berdasarkan status.
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
}
