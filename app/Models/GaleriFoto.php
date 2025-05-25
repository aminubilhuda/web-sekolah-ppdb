<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriFoto extends Model
{
    protected $table = 'galeri_foto';
    
    protected $fillable = [
        'galeri_id',
        'gambar',
        'urutan'
    ];

    protected $casts = [
        'urutan' => 'integer'
    ];

    public function galeri(): BelongsTo
    {
        return $this->belongsTo(Galeri::class);
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
} 