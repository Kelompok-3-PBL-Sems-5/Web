<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
        [
            'kode_prodi' => 'KP02', 
            'nama_prodi' => 'Teknik Informatika', 
            'nidn_user' => '12342', 
            'jenjang' => 'S3'
        ],
        [
            'kode_prodi' => 'KP01', 
            'nama_prodi' => 'Sistem Informasi Bisnis', 
            'nidn_user' => '12343', 
            'jenjang' => 'S1'
        ],
        [
            'kode_prodi' => 'KP01', 
            'nama_prodi' => 'Sistem Informasi Bisnis', 
            'nidn_user' => '12345', 
            'jenjang' => 'S3'
        ],
        [
            'kode_prodi' => 'KP02', 
            'nama_prodi' => 'Teknik Informatika', 
            'nidn_user' => '12344', 
            'jenjang' => 'S2'
        ],
        [
            'kode_prodi' => 'KP01',                                                     
            'nama_prodi' => 'Sistem Informasi Bisnis', 
            'nidn_user' => '12355', 
            'jenjang' => 'S2'
        ],
        ];
        DB::table('data_prodi')->insert($data);
    }
}

