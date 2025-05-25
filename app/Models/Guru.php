<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';
    
    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'bidang_studi',
        'foto',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Get the jurusan that the guru leads.
     */
    public function jurusan(): HasMany
    {
        return $this->hasMany(Jurusan::class, 'kepala_jurusan_id');
    }

    /**
     * Get the mapel for the guru.
     */
    public function mapel(): HasMany
    {
        return $this->hasMany(Mapel::class);
    }
} 