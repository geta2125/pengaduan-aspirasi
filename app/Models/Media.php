<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';

    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_url',
        'caption',
        'mime_type',
        'sort_order',
    ];

    // Relasi ke pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'ref_id', 'pengaduan_id');
    }
}
