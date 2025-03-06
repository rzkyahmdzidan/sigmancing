<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat admin default
        User::create([
            'name' => 'Admin Zidan',
            'email' => 'zrizkyahmad@gmail.com',
            'password' => Hash::make('Zidan321'), // Enkripsi password
            'role' => 'admin', // Role admin
        ]);

        // Informasi untuk debugging (opsional)
        $this->command->info('Admin user berhasil dibuat dengan email zrizkyahmad@gmail.com');
    }
}
