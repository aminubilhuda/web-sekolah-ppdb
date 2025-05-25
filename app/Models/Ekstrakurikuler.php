<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';
    protected $fillable = [
        'nama_ekstrakurikuler',
        'deskripsi',
        'gambar',
        'pembina',
        'status'
    ];

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'pembina', 'nama');
    }
} 