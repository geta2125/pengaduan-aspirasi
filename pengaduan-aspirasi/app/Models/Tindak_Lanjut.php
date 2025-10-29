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

    // Boot method untuk otomatis mengisi petugas
    protected static function booted()
    {
        static::creating(function ($tindak) {
            if (auth()->check()) {
                $tindak->petugas = auth()->user()->nama;
            }
        });
    }
}
