<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateKategoriPengaduan extends Seeder
{
    public function run(): void
    {
        $kategoriList = [
            'Keamanan',
            'Kebersihan',
            'Infrastruktur',
            'Fasilitas Umum',
            'Lingkungan',
            'Sosial',
            'Drainase',
            'Lampu Jalan',
            'Sampah',
            'Air Bersih',
            'Kesehatan',
            'Layanan Umum'
        ];

        for ($i = 1; $i <= 100; $i++) {
            DB::table('kategori_pengaduan')->insert([
                'nama' => $kategoriList[array_rand($kategoriList)], // ⬅ PENTING
                'sla_hari' => rand(1, 10),
                'prioritas' => ['Tinggi', 'Sedang', 'Rendah'][array_rand(['Tinggi', 'Sedang', 'Rendah'])],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
