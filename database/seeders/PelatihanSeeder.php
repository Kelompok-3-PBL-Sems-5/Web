<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 1,
                'id_vendor' => 1,
                'nama_pelatihan' => 'Pelatihan Manajemen ISO 9001',
                'level_pelatihan' => 'Advanced',
                'tgl_mulai' => '2024-01-01',
                'tgl_akhir' => '2025-01-01',
                'jenis_pendanaan' => 'Mandiri',
                'bukti_pelatihan' => 'bukti_pelatihan_1.pdf',
                'status' => 'Aktif',
            ],
            [
                'id_user' => 1,
                'id_vendor' => 2,
                'nama_pelatihan' => 'Pelatihan ISO 14001 Environmental Management',
                'level_pelatihan' => 'Intermediate',
                'tgl_mulai' => '2023-06-01',
                'tgl_akhir' => '2024-06-01',
                'jenis_pendanaan' => 'Pemerintah',
                'bukti_pelatihan' => 'bukti_pelatihan_2.pdf',
                'status' => 'Aktif',
            ],
            [
                'id_user' => 1,
                'id_vendor' => 3,
                'nama_pelatihan' => 'Pelatihan Keamanan Pangan HACCP',
                'level_pelatihan' => 'Beginner',
                'tgl_mulai' => '2024-03-01',
                'tgl_akhir' => '2025-03-01',
                'jenis_pendanaan' => 'Mandiri',
                'bukti_pelatihan' => 'bukti_pelatihan_3.pdf',
                'status' => 'Tidak Aktif',
            ],
        ];
        // Insert data ke tabel t_data_pelatihan
        DB::table('t_data_pelatihan')->insert($data);
    }
}
