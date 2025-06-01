<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    protected $fillable = [
        'judul',
        'deskripsi',
        'image',
        'link',
        'is_published',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_active' => 'boolean'
    ];
}
