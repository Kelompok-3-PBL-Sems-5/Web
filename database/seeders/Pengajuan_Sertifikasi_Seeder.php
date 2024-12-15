<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pengajuan_Sertifikasi_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengajuan_sertifikasi')->insert([
            'id_dosen' => 1, // Sesuaikan dengan ID dosen yang ada di tabel `data_dosen`
            'desc_peng_ser' => 'Pengajuan sertifikasi untuk bidang keahlian teknik informatika.',
            'tujuan_peng_ser' => 'Mendapatkan pengakuan keahlian',
            'anggaran_peng_ser' => 5000000.00, // contoh anggaran
            'jadwal_peng_ser' => '2024-12-01',
        ]);
    }
}
