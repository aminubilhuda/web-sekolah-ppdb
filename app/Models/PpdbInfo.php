<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbInfo extends Model
{
    protected $table = 'ppdb_info';
    
    protected $fillable = [
        'judul',
        'subtitle',
        'gambar_background',
        'persyaratan',
        'jadwal',
        'telepon',
        'whatsapp',
        'email'
    ];

    protected $casts = [
        'persyaratan' => 'array',
        'jadwal' => 'array'
    ];
} 