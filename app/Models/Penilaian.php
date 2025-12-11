<?php

namespace App\Models;

use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function getRatingTextAttribute()
    {
        $stars = ['1' => '⭐', '2' => '⭐⭐', '3' => '⭐⭐⭐', '4' => '⭐⭐⭐⭐', '5' => '⭐⭐⭐⭐⭐'];
        return $stars[$this->rating] ?? '';
    }

    public function scopeForPeriod(Builder $query, $month, $year)
    {
        // Menggunakan nama tabel secara eksplisit untuk menghindari ambiguitas
        $tableName = $query->getModel()->getTable();

        return $query->whereYear("{$tableName}.created_at", $year)
            ->whereMonth("{$tableName}.created_at", $month);
    }
    /**
     * 3. Mendapatkan distribusi rating dalam periode tertentu.
     */
    public static function getRatingDistribusi($month, $year)
    {
        // Panggil scopeForPeriod untuk memfilter data
        // Model Penilaian tidak join dengan Pengaduan untuk mendapatkan rating, jadi ini aman.
        return self::forPeriod($month, $year)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->orderBy('rating')
            ->get();
    }
}
