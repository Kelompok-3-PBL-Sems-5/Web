<?php

namespace App\Exports;

use App\Models\PeriodeModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PeriodeExport
{
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Sertifikasi');
        $sheet->setCellValue('C1', 'Nama User');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Tanggal Dibuat');
        $sheet->setCellValue('F1', 'Tanggal Diperbarui');

        // Style the header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4B5563'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

        // Fetch and populate data
        $periods = Periode::with(['sertifikasi', 'user'])->get();
        $row = 2;
        foreach ($periods as $index => $period) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $period->sertifikasi->nama_sertifikasi);
            $sheet->setCellValue('C' . $row, $period->user->nama_user);
            $sheet->setCellValue('D' . $row, $period->status);
            $sheet->setCellValue('E' . $row, $period->created_at->format('d/m/Y H:i:s'));
            $sheet->setCellValue('F' . $row, $period->updated_at->format('d/m/Y H:i:s'));
            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create the Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'data_periode_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        // Save to temporary file and return the path
        $path = storage_path('app/public/exports/' . $filename);
        $writer->save($path);
        
        return $path;
    }
}