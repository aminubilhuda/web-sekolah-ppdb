<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Galeri extends Model
{
    protected $table = 'galeri';
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'jenis',
        'url_video',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    protected $attributes = [
        'jenis' => 'foto',
        'status' => true
    ];

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public function getVideoUrlAttribute()
    {
        return $this->url_video;
    }

    public function foto(): HasMany
    {
        return $this->hasMany(GaleriFoto::class);
    }
} 