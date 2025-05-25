<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MitraIndustri extends Model
{
    protected $table = 'mitra_industri';
    
    protected $fillable = [
        'nama_perusahaan',
        'logo',
        'bidang_usaha',
        'jenis_kerjasama',
        'deskripsi',
        'alamat',
        'website',
        'email',
        'telepon',
        'status'
    ];
} 