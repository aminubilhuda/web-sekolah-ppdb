<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'image',
        'link',
        'is_published',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
