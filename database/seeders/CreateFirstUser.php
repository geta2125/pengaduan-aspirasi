<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // jangan lupa ini

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin123'), // password default
        ]);
    }
}
