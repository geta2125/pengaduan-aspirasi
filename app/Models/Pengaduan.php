<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status',
    ];

    // ==============================
    // Relasi ke Warga
    // ==============================
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    // ==============================
    // Relasi ke Kategori
    // ==============================
    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id', 'id');
    }

    // ==============================
    // Relasi ke Media (1 lampiran)
    // ==============================
    public function media()
    {
        return $this->hasOne(Media::class, 'ref_id', 'pengaduan_id')
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

}
