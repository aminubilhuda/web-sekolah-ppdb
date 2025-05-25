<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumni extends Model
{
    protected $table = 'alumni';
    
    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'foto',
        'jurusan_id',
        'tahun_lulus',
        'status_bekerja',
        'nama_perusahaan',
        'jabatan',
        'alamat_perusahaan',
        'status_kuliah',
        'nama_kampus',
        'jurusan_kuliah',
        'tahun_masuk',
        'testimoni',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_lulus' => 'integer',
        'tahun_masuk' => 'integer',
        'status_bekerja' => 'boolean',
        'status_kuliah' => 'boolean',
        'status' => 'boolean'
    ];

    /**
     * Get the jurusan that owns the alumni.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Scope a query to only include active alumni.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include alumni who are working.
     */
    public function scopeBekerja($query)
    {
        return $query->where('status_bekerja', true);
    }

    /**
     * Scope a query to only include alumni who are studying.
     */
    public function scopeKuliah($query)
    {
        return $query->where('status_kuliah', true);
    }
} 