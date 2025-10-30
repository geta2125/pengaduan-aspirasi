<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';
    protected $primaryKey = 'penilaian_id';

    // Kolom yang bisa diisi lewat mass assignment
    protected $fillable = [
        'pengaduan_id',
        'rating',
        'komentar',
    ];

    /**
     * Relasi ke Pengaduan
     */
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id', 'pengaduan_id');
    }
}
