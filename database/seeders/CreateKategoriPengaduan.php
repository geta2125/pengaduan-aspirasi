<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriPengaduan;

class CreateKategoriPengaduan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Infrastruktur',
                'sla_hari' => 4,
                'prioritas' => 'Tinggi',
            ],
            [
                'nama' => 'Kebersihan',
                'sla_hari' => 3,
                'prioritas' => 'Sedang',
            ],
            [
                'nama' => 'Keamanan',
                'sla_hari' => 1,
                'prioritas' => 'Tinggi',
            ],
            [
                'nama' => 'Administrasi',
                'sla_hari' => 7,
                'prioritas' => 'Rendah',
            ],
        ];

        foreach ($data as $item) {
            KategoriPengaduan::create($item);
        }
    }
}
