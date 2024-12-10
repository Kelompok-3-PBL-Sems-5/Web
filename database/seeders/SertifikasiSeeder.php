<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SertifikasiSeeder extends Seeder
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
                'nama_sertif' => 'Sertifikasi ISO 9001',
                'jenis_sertif' => 'ISO',
                'tgl_mulai_sertif' => '2024-01-01',
                'tgl_akhir_sertif' => '2025-01-01',
                'jenis_pendanaan_sertif' => 'Mandiri',
                'bukti_sertif' => 'bukti_sertif_1.pdf',
                'status' => 'Aktif',
            ],
            [
                'id_user' => 1,
                'id_vendor' => 2,
                'nama_sertif' => 'Sertifikasi ISO 14001',
                'jenis_sertif' => 'ISO',
                'tgl_mulai_sertif' => '2023-06-01',
                'tgl_akhir_sertif' => '2024-06-01',
                'jenis_pendanaan_sertif' => 'Pemerintah',
                'bukti_sertif' => 'bukti_sertif_2.pdf',
                'status' => 'Aktif',
            ],
            [
                'id_user' => 1,
                'id_vendor' => 3,
                'nama_sertif' => 'Sertifikasi HACCP',
                'jenis_sertif' => 'HACCP',
                'tgl_mulai_sertif' => '2024-03-01',
                'tgl_akhir_sertif' => '2025-03-01',
                'jenis_pendanaan_sertif' => 'Mandiri',
                'bukti_sertif' => 'bukti_sertif_3.pdf',
                'status' => 'Tidak Aktif',
            ],
        ];

        // Insert data ke tabel t_data_sertifikasi
        DB::table('t_data_sertifikasi')->insert($data);
    }
}
