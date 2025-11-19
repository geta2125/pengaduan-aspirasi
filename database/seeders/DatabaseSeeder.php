<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // jangan lupa ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CreateFirstUser::class,
            CreateWargaDummy::class,
            CreateKategoriPengaduan::class,
            CreatePengaduan::class,
            CreateTindakLanjut::class
        ]);
    }
}
