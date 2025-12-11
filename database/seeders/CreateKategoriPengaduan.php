<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateKategoriPengaduan extends Seeder
{
    public function run(): void
    {
        $kategori = [
            'Keamanan Lingkungan',
            'Keamanan Permukiman',
            'Keamanan Jalan Raya',
            'Keamanan Fasilitas Publik',
            'Keamanan Area Sekolah',
            'Keamanan Area Perkantoran',
            'Keamanan Transportasi Umum',
            'Keamanan Malam Hari',
            'Keamanan Anak-Anak',
            'Keamanan Pejalan Kaki',

            'Kebersihan Jalan Utama',
            'Kebersihan Pemukiman',
            'Kebersihan Fasilitas Publik',
            'Kebersihan Sungai dan Danau',
            'Kebersihan Trotoar',
            'Kebersihan Pasar Tradisional',
            'Kebersihan Tempat Wisata',
            'Kebersihan Toilet Umum',
            'Kebersihan Gedung Pemerintah',
            'Kebersihan Area Komersial',

            'Infrastruktur Jalan Berlubang',
            'Infrastruktur Jembatan Rusak',
            'Infrastruktur Trotoar Rusak',
            'Infrastruktur Gedung Publik',
            'Infrastruktur Saluran Air Rusak',
            'Infrastruktur Rambu Lalu Lintas',
            'Infrastruktur Marka Jalan Pudar',
            'Infrastruktur Terminal Bus',
            'Infrastruktur Jalur Sepeda',
            'Infrastruktur Rel Kereta',

            'Fasilitas Umum Rusak',
            'Fasilitas Umum Hilang',
            'Fasilitas Umum Tidak Layak',
            'Fasilitas Umum Tidak Terawat',
            'Fasilitas Umum Kurang Penerangan',
            'Fasilitas Umum Tidak Berfungsi',
            'Fasilitas Olahraga Rusak',
            'Fasilitas Taman Kota',
            'Fasilitas Pendidikan Rusak',
            'Fasilitas Kesehatan Tidak Memadai',

            'Lingkungan Kumuh',
            'Lingkungan Tidak Aman',
            'Lingkungan Tercemar Udara',
            'Lingkungan Tercemar Air',
            'Lingkungan Bising',
            'Lingkungan Bau Menyengat',
            'Lingkungan Hewan Liar',
            'Lingkungan Hama dan Serangga',
            'Lingkungan Kebersihan Minim',
            'Lingkungan Pembuangan Ilegal',

            'Sosial Konflik Warga',
            'Sosial Bantuan Tidak Tepat Sasaran',
            'Sosial Anak Terlantar',
            'Sosial Lansia Terabaikan',
            'Sosial Warga Tidak Mampu',
            'Sosial Pengamen Jalanan',
            'Sosial Penyandang Disabilitas',
            'Sosial Gangguan Ketertiban Umum',
            'Sosial Penyalahgunaan Fasilitas',
            'Sosial Aktivitas Mengganggu',

            'Drainase Tersumbat',
            'Drainase Bocor',
            'Drainase Tidak Mengalir',
            'Drainase Tergenang',
            'Drainase Perlu Perbaikan',
            'Drainase Penuh Endapan',
            'Drainase Tidak Terhubung',
            'Drainase Kotor',
            'Drainase Meluap',
            'Drainase Baru Dibutuhkan',

            'Lampu Jalan Mati',
            'Lampu Jalan Redup',
            'Lampu Jalan Rusak',
            'Lampu Jalan Tidak Ada',
            'Lampu Jalan Tidak Menyala',
            'Lampu Jalan Dicuri',
            'Lampu Jalan Tumbang',
            'Lampu Jalan Tidak Terawat',
            'Lampu Jalan Area Gelap',
            'Lampu Jalan Perlu Penambahan',

            'Sampah Menumpuk',
            'Sampah Tidak Terangkut',
            'Sampah Berserakan',
            'Sampah Sungai',
            'Sampah Pasar',
            'Sampah Rumah Tangga',
            'Sampah Industri',
            'Sampah Hewan',
            'Sampah Plastik Berlebih',
            'Sampah Pembuangan Liar',

            'Air Bersih Tercemar',
            'Air Bersih Tidak Mengalir',
            'Air Bersih Keruh',
            'Air Bersih Berbau',
            'Air Bersih Bocor',
            'Air Bersih Kurang',
            'Air Bersih Tidak Layak',
            'Air Bersih Tersumbat',
            'Air Bersih Bermasalah',
            'Air Bersih Perlu Perbaikan',
        ];

        foreach ($kategori as $nama) {
            DB::table('kategori_pengaduan')->insert([
                'nama'       => $nama,
                'sla_hari'   => rand(1, 10),
                'prioritas'  => ['Tinggi', 'Sedang', 'Rendah'][array_rand(['Tinggi', 'Sedang', 'Rendah'])],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
