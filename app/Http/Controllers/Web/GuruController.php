<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::where('is_active', true)
            ->orderBy('nama')
            ->paginate(12);
            
        return view('web.guru.index', compact('gurus'));
    }

    public function show(Guru $guru)
    {
        // Hanya load guru tanpa relasi yang tidak ada
        return view('web.guru.show', compact('guru'));
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul
        $sheet->setCellValue('A1', 'Format Import Data Guru');
        $sheet->mergeCells('A1:M1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Set header
        $headers = [
            'A2' => 'nama',
            'B2' => 'nip',
            'C2' => 'jabatan',
            'D2' => 'bidang_studi',
            'E2' => 'jenis_kelamin',
            'F2' => 'tempat_lahir',
            'G2' => 'tanggal_lahir',
            'H2' => 'agama',
            'I2' => 'alamat',
            'J2' => 'no_hp',
            'K2' => 'email',
            'L2' => 'deskripsi',
            'M2' => 'status_aktif',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
            $sheet->getStyle($cell)->getFont()->setBold(true);
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($cell)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        }

        // Set lebar kolom
        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Buat file Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_guru.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
} 