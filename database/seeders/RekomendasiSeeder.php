<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekomendasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        [
            'id_program' => '2',
            'jenis_program' => 'Nasional', 
            'nama_program' => 'Sertifikasi', 
            'tanggal_program' => '12 November', 
            'level_program' => '2',
            'kuota_program' => '10'
        ],
        ];
        DB::table('t_data_rekomendasi_program')->insert($data);
    }
}
