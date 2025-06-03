<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FonnteSetting extends Model
{
    protected $fillable = [
        'api_key',
        'admin_number',
        'base_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
} 