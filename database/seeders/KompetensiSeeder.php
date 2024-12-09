<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KompetensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'Nama_Kompetensi' => 'UI/UX'
            ],
            [
                'Nama_Kompetensi' => 'Web Developer'
            ],
            [
                'Nama_Kompetensi' => 'Game Developer'
            ],
            ];
        DB::table('kompetensi')->insert($data);
    }
}
