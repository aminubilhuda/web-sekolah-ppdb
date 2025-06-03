<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Log;

class GuruImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function headingRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        Log::info('Row import:', $row);
        return new Guru([
            'nama' => $row['nama'],
            'nip' => $row['nip'] ?? null,
            'jabatan' => $row['jabatan'] ?? null,
            'bidang_studi' => $row['bidang_studi'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
            'agama' => $row['agama'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'email' => $row['email'] ?? null,
            'deskripsi' => $row['deskripsi'] ?? null,
            'is_active' => filter_var($row['status_aktif'] ?? true, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|max:255',
            'nip' => 'nullable|max:255',
            'jabatan' => 'nullable|max:255',
            'bidang_studi' => 'nullable|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'nullable|max:255',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'alamat' => 'nullable',
            'no_hp' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'status_aktif' => 'nullable|in:true,false',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'nip.max' => 'NIP maksimal 255 karakter',
            'jabatan.max' => 'Jabatan maksimal 255 karakter',
            'bidang_studi.max' => 'Bidang studi maksimal 255 karakter',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
            'tempat_lahir.max' => 'Tempat lahir maksimal 255 karakter',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'agama.in' => 'Agama harus salah satu dari: Islam, Kristen, Katolik, Hindu, Buddha, Konghucu',
            'no_hp.max' => 'Nomor HP maksimal 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'status_aktif.in' => 'Status aktif harus true atau false',
        ];
    }
}