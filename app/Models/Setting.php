<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'description',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value, $group = 'general', $description = null)
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->group = $group;
        $setting->description = $description;
        $setting->save();
        return $setting;
    }
} 