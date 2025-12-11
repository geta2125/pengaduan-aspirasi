<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pengaduan;

class CreateTindakLanjut extends Seeder
{
    public function run(): void
    {
        // Optional: bersihin dulu tabel tindak_lanjut biar nggak dobel
        // DB::table('tindak_lanjut')->truncate();

        $petugasList = [
            'Budi Santoso',
            'Siti Aminah',
            'Joko Prasetyo',
            'Rina Kartika',
            'Andi Wijaya',
            'Dewi Lestari',
            'Ahmad Fauzan',
        ];

        $rows = [];

        // Ambil semua pengaduan (100 yang kamu seed tadi)
        $pengaduanList = Pengaduan::with('kategori')->get();

        foreach ($pengaduanList as $pengaduan) {
            $kategoriNama = $pengaduan->kategori->nama ?? 'Pengaduan';
            $baseInfo = 'Laporan ' . strtolower($kategoriNama) .
                ' dengan nomor tiket ' . $pengaduan->nomor_tiket .
                ' di ' . $pengaduan->lokasi_text .
                ' (RT ' . $pengaduan->rt . '/RW ' . $pengaduan->rw . ')';

            $createdAt = now()->subMinutes(rand(60, 120)); // waktu awal agak mundur

            // ✳️ 1. Status "Diterima" — selalu ada
            $rows[] = [
                'pengaduan_id' => $pengaduan->pengaduan_id,
                'petugas'      => $petugasList[array_rand($petugasList)],
                'aksi'         => 'Diterima',
                'catatan'      => $baseInfo . ' telah diterima oleh admin dan menunggu penanganan.',
                'created_at'   => $createdAt,
                'updated_at'   => $createdAt,
            ];

            // ✳️ 2. Kalau status PROSES atau SELESAI → tambahkan "Sedang Diproses"
            if (in_array($pengaduan->status, ['proses', 'selesai'])) {
                $createdAtProses = $createdAt->copy()->addMinutes(rand(5, 30));

                $rows[] = [
                    'pengaduan_id' => $pengaduan->pengaduan_id,
                    'petugas'      => $petugasList[array_rand($petugasList)],
                    'aksi'         => 'Sedang Diproses',
                    'catatan'      => $baseInfo . ' sedang dalam proses penanganan oleh petugas lapangan.',
                    'created_at'   => $createdAtProses,
                    'updated_at'   => $createdAtProses,
                ];
            }

            // ✳️ 3. Kalau status SELESAI → tambahkan "Selesai"
            if ($pengaduan->status === 'selesai') {
                $createdAtSelesai = $createdAt->copy()->addMinutes(rand(30, 90));

                $rows[] = [
                    'pengaduan_id' => $pengaduan->pengaduan_id,
                    'petugas'      => $petugasList[array_rand($petugasList)],
                    'aksi'         => 'Selesai',
                    'catatan'      => $baseInfo . ' telah diselesaikan. Warga diminta untuk mengonfirmasi bila masih ada kendala.',
                    'created_at'   => $createdAtSelesai,
                    'updated_at'   => $createdAtSelesai,
                ];
            }
        }

        DB::table('tindak_lanjut')->insert($rows);
    }
}
