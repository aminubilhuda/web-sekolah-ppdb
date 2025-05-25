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
        'deskripsi',
        'gambar',
        'kepala_jurusan_id',
        'status'
    ];

    public function kepalaJurusan(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'kepala_jurusan_id');
    }

    public function alumni(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }
} 