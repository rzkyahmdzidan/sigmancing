<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spots')->insert([
            [
                'nama' => 'Pantai Lhokseumawe',
                'deskripsi' => 'Spot memancing favorit di pantai dengan banyak jenis ikan.',
                'latitude' => 5.21051,
                'longitude' => 97.13507,
                'foto' => 'photos/pantai_lhokseumawe.jpg',
                'rekomendasi_umpan' => 'Umpan cacing laut dan udang segar.',
                'rekomendasi_cuaca' => 'Pagi hari saat cuaca cerah.',
            ],
            [
                'nama' => 'Muara Sungai',
                'deskripsi' => 'Spot di muara sungai yang kaya akan ikan predator.',
                'latitude' => 5.22500,
                'longitude' => 97.14200,
                'foto' => 'photos/muara_sungai.jpg',
                'rekomendasi_umpan' => 'Umpan ikan kecil dan cumi-cumi.',
                'rekomendasi_cuaca' => 'Sore hari sebelum matahari terbenam.',
            ],
        ]);
    }
}
