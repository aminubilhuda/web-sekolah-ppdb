<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    protected $table = 'siswa';
    
    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'kelas',
        'jurusan_id',
        // Data Orang Tua
        'nama_ayah',
        'nik_ayah',
        'pekerjaan_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'nik_ibu',
        'pekerjaan_ibu',
        'no_hp_ibu',
        // Data Wali
        'nama_wali',
        'nik_wali',
        'pekerjaan_wali',
        'no_hp_wali',
        'hubungan_wali',
        'foto',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'status' => 'boolean'
    ];

    /**
     * Get the jurusan that owns the siswa.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
} 