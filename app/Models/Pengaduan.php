<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Media;
use App\Models\Warga;
use App\Models\Penilaian;
use App\Models\Tindak_Lanjut;
use App\Models\KategoriPengaduan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $primaryKey = 'pengaduan_id';
    protected $fillable = [
        'nomor_tiket',
        'warga_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'lokasi_text',
        'rt',
        'rw',
        'status', // Kolom status yang akan digunakan
    ];

    // ==============================
    // RELATIONS
    // ==============================
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id', 'kategori_id');    }

    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'pengaduan_id')
            ->where('ref_table', 'pengaduan');
    }

    public function tindak_lanjut()
    {
        return $this->hasMany(Tindak_Lanjut::class, 'pengaduan_id', 'pengaduan_id');
    }

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'pengaduan_id', 'pengaduan_id');
    }

    // ==============================
    // SCOPES
    // ==============================

    public function scopeForPeriod(Builder $query, $month, $year): void
    {
        // Ganti whereYear('created_at') menjadi whereYear('pengaduan.created_at')
        $query->whereYear('pengaduan.created_at', $year)
            // Ganti whereMonth('created_at') menjadi whereMonth('pengaduan.created_at')
            ->whereMonth('pengaduan.created_at', $month);
    }

    // --- METODE YANG DIBUTUHKAN CONTROLLER ---

    // 1. DATA KATEGORI (Sudah Ada, tetapi disertakan untuk konteks lengkap)
    public static function getPengaduanPerKategori($month, $year)
    {
        // Fungsi SUBSTRING_INDEX(string, delimiter, count)
        // Di sini, kita mengambil semua karakter sebelum spasi pertama (' ')
        $grouping_label = 'SUBSTRING_INDEX(kategori_pengaduan.nama, " ", 1)';

        return self::select(
            // 1. Ambil kata pertama (misal: 'Keamanan') dan beri alias 'nama'
            DB::raw("{$grouping_label} as nama"),
            // 2. Hitung total pengaduan
            DB::raw('COUNT(pengaduan.pengaduan_id) as total')
        )
            ->join('kategori_pengaduan', 'pengaduan.kategori_id', '=', 'kategori_pengaduan.kategori_id')

            // Filter periode (sudah diperbaiki dengan nama tabel)
            ->whereYear('pengaduan.created_at', $year)
            ->whereMonth('pengaduan.created_at', $month)

            // Kelompokkan berdasarkan kata pertama yang kita buat di SELECT
            ->groupBy(DB::raw($grouping_label))

            ->orderByDesc('total')
            ->limit(10)
            ->get();
    }

    // 2. DATA RATING/PENILAIAN (Menggunakan JOIN ke tabel 'penilaian')
    public static function getPengaduanPerRating($month, $year)
    {
        return self::forPeriod($month, $year)
            // Sesuaikan kolom JOIN jika foreign key Anda berbeda!
            ->join('penilaian', 'pengaduan.pengaduan_id', '=', 'penilaian.pengaduan_id')
            ->selectRaw('penilaian.rating as label, COUNT(pengaduan.pengaduan_id) as total')
            ->whereNotNull('penilaian.rating')
            ->groupBy('penilaian.rating')
            ->orderByDesc('total')
            ->get();
    }

    // 3. DATA STATUS (Menggunakan nilai ENUM: pending, proses, selesai)
    public static function getPengaduanStatus($periodType, $month, $year)
    {
        $query = self::query();

        // Terapkan Filter Berdasarkan Periode
        if ($periodType === 'year') {
            $query->whereYear('created_at', $year);
        } elseif ($periodType === 'month') {
            $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } elseif ($periodType === 'week') {
            // Mengambil 7 hari terakhir dari TANGGAL HARI INI
            $query->where('created_at', '>=', Carbon::now()->subDays(6));
        }

        $expectedStatuses = ['pending', 'proses', 'selesai'];

        $rawStatusData = $query->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $formattedData = [];
        foreach ($expectedStatuses as $status) {
            $formattedData[] = $rawStatusData[$status] ?? 0;
        }

        return $formattedData;
    }

    // 4. DATA RINGKASAN COUNT

    // a. Menghitung total warga unik yang membuat pengaduan
    public static function getTotalWarga($month, $year)
    {
        return self::forPeriod($month, $year)
            // Asumsi kolom foreign key warga adalah 'warga_id'
            ->distinct('warga_id')
            ->count('warga_id');
    }

    // b. Menghitung total pengaduan
    public static function getTotalPengaduanCount($month, $year)
    {
        return self::forPeriod($month, $year)->count();
    }

    // c. Menghitung total kategori pengaduan unik yang digunakan
    public static function getTotalKategoriCount($month, $year)
    {
        return self::forPeriod($month, $year)
            // Asumsi kolom foreign key kategori adalah 'kategori_id'
            ->distinct('kategori_id')
            ->count('kategori_id');
    }

    // d. Mengambil warga pelapor teratas
    public static function getWargaTeratas($month, $year) // Di Controller disebut getWargaTeratas
    {
        // Panggilan di Controller Anda adalah $wargaTeratas = Pengaduan::getWargaTeratas($month, $year);
        // Metode ini akan menggunakan logika dari getWargaPelaporTeratas

        return self::forPeriod($month, $year)
            ->join('warga', 'pengaduan.warga_id', '=', 'warga.warga_id')
            ->selectRaw('warga.nama, count(pengaduan.pengaduan_id) as total_pengaduan')
            ->groupBy('warga.nama')
            ->orderByDesc('total_pengaduan')
            ->limit(5)
            ->get();
    }
}
