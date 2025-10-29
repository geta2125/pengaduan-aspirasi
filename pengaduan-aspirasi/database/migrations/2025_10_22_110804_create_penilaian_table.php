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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->bigIncrements('penilaian_id');

            // Sesuaikan dengan kolom pengaduan_id di tabel pengaduan
            $table->unsignedBigInteger('pengaduan_id');
            $table->unsignedTinyInteger('rating')->comment('Skala 1-5');
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('pengaduan_id')
                ->references('pengaduan_id')
                ->on('pengaduan')
                ->onDelete('cascade');
        });
    }

    /**
     * Hapus tabel saat rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
