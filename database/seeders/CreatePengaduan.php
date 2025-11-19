<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;

class CreatePengaduan extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nomor_tiket' => 'PNG-0001',
                'warga_id' => 1,
                'kategori_id' => 1,
                'judul' => 'Lampu Jalan Mati',
                'deskripsi' => 'Lampu jalan mati sejak 3 hari lalu.',
                'status' => 'pending',
                'lokasi_text' => 'Jalan Kenanga',
                'rt' => '02',
                'rw' => '03',
            ],
            [
                'nomor_tiket' => 'PNG-0002',
                'warga_id' => 2,
                'kategori_id' => 2,
                'judul' => 'Sampah Menumpuk',
                'deskripsi' => 'Sampah belum diangkut sejak minggu lalu.',
                'status' => 'proses',
                'lokasi_text' => 'Jalan Melati',
                'rt' => '05',
                'rw' => '02',
            ],
            [
                'nomor_tiket' => 'PNG-0003',
                'warga_id' => 1,
                'kategori_id' => 3,
                'judul' => 'Keributan Malam Hari',
                'deskripsi' => 'Warga melaporkan suara gaduh dari rumah kontrakan.',
                'status' => 'selesai',
                'lokasi_text' => 'Gang Mawar',
                'rt' => '01',
                'rw' => '04',
            ],
        ];

        foreach ($data as $item) {
            Pengaduan::create($item);
        }
    }
}
