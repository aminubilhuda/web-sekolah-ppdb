<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPrestasi extends Model
{
    protected $table = 'kategori_prestasi';
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi'
    ];

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'kategori_id');
    }
} 