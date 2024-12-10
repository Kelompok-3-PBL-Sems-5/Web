<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder {
    /**
     *  Run the database seeds.
     */

     public function run() {
        $data = [
            ['id_level' => 1, 'kode_level' => 'ADM', 'nama_level' => 'Administrator'],
            ['id_level' => 2, 'kode_level' => 'PIMJUR', 'nama_level' => 'Pimpinan Jurusan'],
            ['id_level' => 3, 'kode_level' => 'DSN', 'nama_level' => 'Dosen'],
        ];
        DB::table('m_level')->insert($data);
     }
}