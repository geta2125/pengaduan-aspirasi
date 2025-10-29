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
            $table->string('ref_table')->nullable()->comment('Nama tabel referensi');
            $table->unsignedBigInteger('ref_id')->nullable()->comment('ID data referensi');
            $table->string('file_url')->comment('Path atau URL file media');
            $table->string('caption')->nullable()->comment('Keterangan file');
            $table->string('mime_type', 100)->nullable()->comment('Tipe MIME file, contoh: image/jpeg');
            $table->integer('sort_order')->default(0)->comment('Urutan tampilan media');
            $table->timestamps();
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
