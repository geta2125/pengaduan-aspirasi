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
            'nama' => 'Geta',
            'email' => 'geta@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('geta2125'), // password default
        ]);
    }
}
