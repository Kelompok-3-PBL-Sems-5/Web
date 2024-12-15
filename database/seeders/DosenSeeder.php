<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_user')->insert([
            [
                'nama_user' => 'Ade Ismail, S.Kom., M.TI',
                'username_user' => 'adeismail',
                'password_user' => Hash::make('password123'), // Hashing dengan Laravel
                'nidn_user' => '404079101',
                'gelar_akademik' => 'M.TI',
                'email_user' => 'adeismail@example.com',
            ],
            [
                'nama_user' => 'Agung Nugroho Pramudhita, S.T., M.T.',
                'username_user' => 'agungnugrohopramudhita',
                'password_user' => Hash::make('password123'),
                'nidn_user' => '10028903',
                'gelar_akademik' => 'M.T.',
                'email_user' => 'agungnugrohopramudhita@example.com',
            ],
            [
                'nama_user' => 'Ahmadi Yuli Ananta, ST., M.M.',
                'username_user' => 'ahmadiyuliananta',
                'password_user' => Hash::make('password123'),
                'nidn_user' => '5078102',
                'gelar_akademik' => 'M.M.',
                'email_user' => 'ahmadiyuliananta@example.com',
            ],
            [
                'nama_user' => 'Annisa Puspa Kirana, S.Kom., M.Kom',
                'username_user' => 'annisapuspakirana',
                'password_user' => Hash::make('password123'),
                'nidn_user' => '23018906',
                'gelar_akademik' => 'M.Kom',
                'email_user' => 'annisapuspakirana@example.com',
            ],
            [
                'nama_user' => 'Annisa Taufika Firdausi, ST., MT.',
                'username_user' => 'annisataufikafirdausi',
                'password_user' => Hash::make('password123'),
                'nidn_user' => '14128704',
                'gelar_akademik' => 'MT.',
                'email_user' => 'annisataufikafirdausi@example.com',
            ],
            // Tambahkan data lainnya di sini
        ]);
    }
}
