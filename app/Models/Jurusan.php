<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    
    protected $fillable = [
        'nama_jurusan',
        'singkatan',
        'deskripsi',
        'gambar',
        'kepala_jurusan_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Get the kepala jurusan that owns the jurusan.
     */
    public function kepalaJurusan(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'kepala_jurusan_id');
    }

    /**
     * Get the siswa for the jurusan.
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * Get the alumni for the jurusan.
     */
    public function alumni(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }
} 