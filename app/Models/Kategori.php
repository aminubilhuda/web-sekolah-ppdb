<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi'
    ];

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
} 