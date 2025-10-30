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
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->bigIncrements('tindak_id');

            // sesuaikan foreign key dengan kolom 'pengaduan_id'
            $table->unsignedBigInteger('pengaduan_id');
            $table->string('petugas');
            $table->string('aksi');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // foreign key
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
        Schema::dropIfExists('tindak_lanjut');
    }
};
