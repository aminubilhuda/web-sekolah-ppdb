<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'jenis', // foto/video
        'url_video', // untuk video
        'status'
    ];
} 