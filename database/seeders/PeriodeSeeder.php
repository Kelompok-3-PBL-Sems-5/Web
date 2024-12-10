<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\PeriodeModel;
use App\Models\UserModel;
use App\Models\SertifikasiModel;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        $periodes = [
            [
                'id_sertifikasi' => 1,
                'id_user' => 1,
                'status' => 'Aktif'
            ],
            [
                'id_sertifikasi' => 1,
                'id_user' => 2,
                'status' => 'Tidak Aktif'
            ],
            [
                'id_sertifikasi' => 2,
                'id_user' => 3,
                'status' => 'Aktif'
            ],
            [
                'id_sertifikasi' => 2,
                'id_user' => 4,
                'status' => 'Tidak Aktif'
            ],
            [
                'id_sertifikasi' => 3,
                'id_user' => 5,
                'status' => 'Aktif'
            ]
        ];

        DB::table('t_periode')->insert($periodes);
    }
}