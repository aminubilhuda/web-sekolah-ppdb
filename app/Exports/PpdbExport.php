<?php

namespace App\Exports;

use App\Models\PPDB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PpdbExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PPDB::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Pendaftaran',
            'Nama Lengkap',
            'NISN',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Alamat',
            'No. HP',
            'Asal Sekolah',
            'Tahun Lulus',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'No. HP Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'No. HP Ibu',
            'Alamat Orang Tua',
            'Jurusan Pilihan',
            'Status',
            'Tanggal Daftar'
        ];
    }

    public function map($ppdb): array
    {
        static $no = 1;
        return [
            $no++,
            $ppdb->nomor_pendaftaran,
            $ppdb->nama_lengkap,
            $ppdb->nisn,
            $ppdb->nik,
            $ppdb->tempat_lahir,
            $ppdb->tanggal_lahir,
            $ppdb->jenis_kelamin,
            $ppdb->agama,
            $ppdb->alamat,
            $ppdb->no_hp,
            $ppdb->asal_sekolah,
            $ppdb->tahun_lulus,
            $ppdb->nama_ayah,
            $ppdb->pekerjaan_ayah,
            $ppdb->no_hp_ayah,
            $ppdb->nama_ibu,
            $ppdb->pekerjaan_ibu,
            $ppdb->no_hp_ibu,
            $ppdb->alamat_ortu,
            $ppdb->jurusan->nama_jurusan ?? '-',
            $ppdb->status,
            $ppdb->created_at->format('d/m/Y H:i')
        ];
    }
} 