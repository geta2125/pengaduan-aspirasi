<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateTindakLanjut extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'pengaduan_id' => 1,
                'petugas' => 'Budi Santoso',
                'aksi' => 'Diterima',
                'catatan' => 'Laporan telah diterima oleh admin.',
                'aksi' => 'Diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengaduan_id' => 2,
                'petugas' => 'Siti Aminah',
                'aksi' => 'Sedang Diproses',
                'catatan' => 'Petugas kebersihan sedang menuju lokasi.',
                'aksi' => 'Sedang Diproses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pengaduan_id' => 3,
                'petugas' => 'Joko Prasetyo',
                'aksi' => 'Selesai',
                'catatan' => 'Permasalahan sudah ditangani dan diselesaikan.',
                'aksi' => 'Selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tindak_lanjut')->insert($data);
    }
}
