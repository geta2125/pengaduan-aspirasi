<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaduan;
use App\Models\KategoriPengaduan;

class CreatePengaduan extends Seeder
{
    public function run(): void
    {
        // Ambil kategori yang sudah dibuat (pakai PK yang benar)
        $kategoriList = KategoriPengaduan::select('kategori_id', 'nama')->get();

        // Kalau belum ada kategori, stop biar nggak error
        if ($kategoriList->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 100; $i++) {

            // Ambil kategori sesuai index, kalau kurang dari 100 pakai random
            $kategori = $kategoriList->get($i - 1) ?? $kategoriList->random();

            $nomorTiket = 'PNG-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            Pengaduan::create([
                'nomor_tiket' => $nomorTiket,
                'warga_id'    => rand(1, 50),
                'kategori_id' => $kategori->kategori_id,   
                'judul'       => 'Laporan ' . $kategori->nama,
                'deskripsi'   => 'Pengaduan terkait ' . strtolower($kategori->nama),
                'status'      => 'pending',                // ✅ hanya pending
                'lokasi_text' => 'Lokasi pengaduan ke-' . $i,
                'rt'          => str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT),
                'rw'          => str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
