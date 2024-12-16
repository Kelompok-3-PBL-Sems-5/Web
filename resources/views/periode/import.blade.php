<?php

namespace App\Imports;

use App\Models\Periode;
use App\Models\SertifikasiModel;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Exception;

class PeriodeImport
{
    public function import($file)
    {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        // Remove header row
        array_shift($rows);
        
        $successful = 0;
        $failed = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            try {
                // Validate data
                $validator = Validator::make([
                    'nama_sertifikasi' => $row[1],
                    'nama_user' => $row[2],
                    'status' => $row[3],
                ], [
                    'nama_sertifikasi' => 'required',
                    'nama_user' => 'required',
                    'status' => 'required|in:Aktif,Tidak Aktif',
                ]);

                if ($validator->fails()) {
                    $failed++;
                    $errors[] = "Baris " . ($index + 2) . ": " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Find related records
                $sertifikasi = SertifikasiModel::where('nama_sertifikasi', $row[1])->first();
                $user = User::where('nama_user', $row[2])->first();

                if (!$sertifikasi || !$user) {
                    $failed++;
                    $errors[] = "Baris " . ($index + 2) . ": Sertifikasi atau User tidak ditemukan";
                    continue;
                }

                // Create periode record
                Periode::create([
                    'id_sertifikasi' => $sertifikasi->id_sertifikasi,
                    'id_user' => $user->id_user,
                    'status' => $row[3]
                ]);

                $successful++;
            } catch (Exception $e) {
                $failed++;
                $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        return [
            'status' => true,
            'successful' => $successful,
            'failed' => $failed,
            'errors' => $errors
        ];
    }
}