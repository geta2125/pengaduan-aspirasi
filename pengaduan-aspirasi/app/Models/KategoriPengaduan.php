<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPengaduan extends Model
{
    protected $table = 'kategori_pengaduan'; // pastikan nama tabel sesuai di database

    protected $fillable = [
        'nama',
        'sla_hari',
        'prioritas',
    ];
}
