<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_vendor' => 1,
                'nama_vendor' => 'PT. Pelatihan Nusantara',
                'alamat_vendor' => 'Jl. Merdeka No.1 Jakarta',
                'telp_vendor' => '081234567890',
                'jenis_vendor' => 'Pelatihan Teknologi'
            ],
            [
                'id_vendor' => 2,
                'nama_vendor' => 'CV. Sertifikasi Indonesia',
                'alamat_vendor' => 'Jl. Soekarno Hatta No.2 Bandung',
                'telp_vendor' => '082345678901',
                'jenis_vendor' => 'Sertifikasi Internasional'
            ],
            [
                'id_vendor' => 3,
                'nama_vendor' => 'PT. Akademi IT',
                'alamat_vendor' => 'Jl. Sudirman No.3 Surabaya',
                'telp_vendor' => '083456789012',
                'jenis_vendor' => 'Pelatihan Pemrograman'
            ],
            [
                'id_vendor' => 4,
                'nama_vendor' => 'CV. Edukasi Cerdas',
                'alamat_vendor' => 'Jl. Kartini No.4 Yogyakarta',
                'telp_vendor' => '084567890123',
                'jenis_vendor' => 'Workshop Bisnis'
            ],
            [
                'id_vendor' => 5,
                'nama_vendor' => 'PT. Pelatihan Maju',
                'alamat_vendor' => 'Jl. Gatot Subroto No.5 Medan',
                'telp_vendor' => '085678901234',
                'jenis_vendor' => 'Pelatihan Manajemen'
            ]
        ];
        DB::table('t_vendor')->insert($data);
    }
}
