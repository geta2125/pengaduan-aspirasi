<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindak_Lanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut';
    protected $primaryKey = 'tindak_id';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'pengaduan_id',
        'petugas',
        'aksi',
        'catatan',
    ];

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }

    public function media()
    {
        // Mengubah hasOne menjadi hasMany
        return $this->hasMany(Media::class, 'ref_id', 'tindak_id')
            ->where('ref_table', 'tindak_lanjut');
    }
}
