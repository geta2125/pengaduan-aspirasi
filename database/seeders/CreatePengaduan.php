<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;

class CreatePengaduan extends Seeder
{
    public function run(): void
    {
        // Ambil 100 kategori yang sudah dibuat
        $kategoriList = KategoriPengaduan::select('id', 'nama')->get();

        $statusList = ['pending', 'proses', 'selesai'];

        for ($i = 1; $i <= 100; $i++) {

            // Kategori sesuai index (biar sinkron)
            $kategori = $kategoriList[$i - 1]; // urut 1 → 100

            // Buat nomor tiket
            $nomorTiket = 'PNG-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            Pengaduan::create([
                'nomor_tiket' => $nomorTiket,
                'warga_id' => rand(1, 50),
                'kategori_id' => $kategori->id,

                // 🟢 JUDUL SINKRON DENGAN KATEGORI
                'judul' => 'Laporan ' . $kategori->nama,

                // 🟢 DESKRIPSI JUGA SINKRON
                'deskripsi' => 'Pengaduan terkait ' . strtolower($kategori->nama),

                'status' => $statusList[array_rand($statusList)],
                'lokasi_text' => 'Lokasi pengaduan ke-' . $i,
                'rt' => str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT),
                'rw' => str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
