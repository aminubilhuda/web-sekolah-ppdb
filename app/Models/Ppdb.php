<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ppdb extends Model
{
    protected $table = 'ppdb';
    protected $fillable = [
        'nama_lengkap',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'nama_ortu',
        'no_hp',
        'asal_sekolah',
        'jurusan_pilihan',
        'foto',
        'ijazah',
        'kk',
        'status'
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan', 'id');
    }
} 