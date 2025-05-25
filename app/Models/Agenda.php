<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agenda';
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'penanggung_jawab',
        'is_published'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
} 