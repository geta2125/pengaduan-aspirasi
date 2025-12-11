<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateWargaDummy extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        foreach (range(1, 100) as $index) {

            // Insert ke tabel users (default Laravel)
            $userId = DB::table('user')->insertGetId([
                'nama' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password123'),
                'role' => 'guest',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Insert ke tabel warga
            DB::table('warga')->insert([
                'user_id' => $userId,
                'no_ktp' => $faker->numerify('################'), // 16 digit
                'nama' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama' => $faker->randomElement(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'email' => $faker->unique()->safeEmail(),
                'telp' => $faker->numerify('08##########'),
                'pekerjaan' => $faker->jobTitle(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
