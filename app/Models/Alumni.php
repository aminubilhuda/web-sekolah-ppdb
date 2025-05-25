<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alumni extends Model
{
    protected $table = 'alumni';
    protected $fillable = [
        'nama',
        'tahun_lulus',
        'jurusan_id',
        'testimoni',
        'tempat_kerja',
        'jabatan',
        'foto',
        'status'
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
} 