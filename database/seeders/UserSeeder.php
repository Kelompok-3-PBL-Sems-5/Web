<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 1,
                'id_level' => 1,
                'nama_user' => 'admin',
                'username_user' => 'admin',
                'password_user' => Hash::make('admin'),
                'nidn_user' => '12345',
                'gelar_akademik' => 'S.ST',
                'email_user' => 'admin@gmail.com',
                'foto' => ''
            ],
        ];
        DB::table('m_user')->insert($data);
    }
}