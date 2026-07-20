<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'username'     => 'admin',
            'password'     => Hash::make('password123'),
            'nama_lengkap' => 'Administrator TRITON',
            'role'         => 'Admin',
        ]);

        // 2. Akun Posbakum
        User::create([
            'username'     => 'posbakum',
            'password'     => Hash::make('password123'),
            'nama_lengkap' => 'Petugas Posbakum',
            'role'         => 'Posbakum',
        ]);

        // 3. Akun Petugas PTSP
        User::create([
            'username'     => 'ptsp',
            'password'     => Hash::make('password123'),
            'nama_lengkap' => 'Petugas PTSP Hukum',
            'role'         => 'Petugas PTSP',
        ]);

        // 4. Akun Petugas Back Office
        User::create([
            'username'     => 'backoffice',
            'password'     => Hash::make('password123'),
            'nama_lengkap' => 'Petugas Back Office',
            'role'         => 'Petugas Back Office',
        ]);
    }
}