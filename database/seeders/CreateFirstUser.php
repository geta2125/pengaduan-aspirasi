<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // Super admin
            [
                'nama' => 'Geta Dewi Artika Sari',
                'email' => 'getadewiartikasari@gmail.com',
                'role' => 'super admin',
                'password' => 'Geta Dewi Artika Sari',
            ],

            // Admin
            [
                'nama' => 'Geta',
                'email' => 'geta@gmail.com',
                'role' => 'admin',
                'password' => 'geta2125',
            ],
            [
                'nama' => 'Muhammad Harlan Setiawan',
                'email' => 'harlan@gmail.com',
                'role' => 'admin',
                'password' => 'Muhammad Harlan Setiawan',
            ],

            // Petugas
            [
                'nama' => 'Petugas',
                'email' => 'petugas@gmail.com',
                'role' => 'petugas',
                'password' => 'petugas',
            ],

            // Guest
            [
                'nama' => 'Geta Dewi',
                'email' => 'getadewi@gmail.com',
                'role' => 'guest',
                'password' => 'Geta Dewi',
            ],
            [
                'nama' => 'Geta Dewi AS',
                'email' => 'getadewias@gmail.com',
                'role' => 'guest',
                'password' => '1234567890',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']], // patokan unik
                [
                    'nama' => $u['nama'],
                    'role' => $u['role'],
                    'password' => Hash::make($u['password']),
                ]
            );
        }
    }
}
