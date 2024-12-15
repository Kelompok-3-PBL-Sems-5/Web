<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 1,
                'kode_matkul' => 'MK001',
                'nama_matkul' => 'Pemrograman Web',
            ],
            [
                'id_user' => 2,
                'kode_matkul' => 'MK002',
                'nama_matkul' => 'Basis Data',
            ],
            [
                'id_user' => 3,
                'kode_matkul' => 'MK003',
                'nama_matkul' => 'Audit Sistem Informasi',
            ],
        ];

        DB::table('mata_kuliah')->insert($data);
    }
}
