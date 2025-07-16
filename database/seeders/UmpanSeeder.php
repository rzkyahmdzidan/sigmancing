<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmpanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('umpans')->insert([
            [
                'id' => 1,
                'nama' => 'Udang Hidup',
                'kategori' => 'Natural Bait',
                'jenis_ikan' => 'Kakap, Gurami',
                'jenis_air' => 'Air Tawar',
                'waktu_terbaik' => 'Sore',
                'deskripsi' => null,
                'badge' => 'Best Choice',
                'status' => 1,
                'created_at' => '2025-02-22 20:57:10',
                'updated_at' => '2025-03-06 07:57:59',
            ],
            [
                'id' => 3,
                'nama' => 'Anak Ikan Belanak',
                'kategori' => 'Natural Bait',
                'jenis_ikan' => 'Kakap',
                'jenis_air' => 'Air Tawar',
                'waktu_terbaik' => 'Sore',
                'deskripsi' => 'Cocok Untuk Pemancing Handal!',
                'badge' => 'Recommended',
                'status' => 1,
                'created_at' => '2025-03-06 07:57:40',
                'updated_at' => '2025-03-19 12:23:13',
            ],
        ]);
    }
}
