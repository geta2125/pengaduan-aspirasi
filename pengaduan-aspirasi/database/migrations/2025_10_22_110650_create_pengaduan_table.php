<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->bigIncrements('pengaduan_id');
            $table->string('nomor_tiket')->unique();
        
            $table->unsignedInteger('warga_id'); // sama tipe dengan increments()
            $table->unsignedBigInteger('kategori_id');
        
            $table->string('judul');
            $table->text('deskripsi');
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->string('lokasi_text')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->timestamps();
        
            // Foreign keys
            $table->foreign('warga_id')
                ->references('warga_id')
                ->on('warga')
                ->onDelete('cascade');
        
            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori_pengaduan')
                ->onDelete('cascade');
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
