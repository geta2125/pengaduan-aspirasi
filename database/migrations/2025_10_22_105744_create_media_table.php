<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');

            // 1. Wajib diisi (Hapus nullable) agar tidak ada file tanpa pemilik
            $table->string('ref_table')->comment('Nama tabel referensi (contoh: pengaduan)');
            $table->unsignedBigInteger('ref_id')->comment('ID dari data referensi');

            // 2. Data File
            $table->string('file_name')->comment('Nama file saja (contoh: bukti.jpg)');
            $table->string('caption')->nullable()->comment('Keterangan file');
            $table->string('mime_type', 100)->nullable()->comment('Tipe MIME, contoh: image/jpeg');
            $table->integer('sort_order')->default(0)->comment('Urutan tampilan media');

            $table->timestamps();

            // 3. TAMBAHAN PENTING: Indexing
            // Ini membuat loading gambar di halaman detail jadi ngebut
            $table->index(['ref_table', 'ref_id']);
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
