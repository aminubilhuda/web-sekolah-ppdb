<?php

namespace App\Models;

use Carbon\Carbon;
use ArrayAccess;
use JsonSerializable;

class FileModel implements ArrayAccess, JsonSerializable
{
    protected $attributes = [];
    
    // Fillable attributes
    protected $fillable = [
        'id',
        'name', 
        'path',
        'size',
        'type',
        'modified',
        'directory',
        'url'
    ];

    // Cast attributes
    protected $casts = [
        'modified' => 'datetime',
        'size' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    // Fill attributes like Eloquent Model
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->setAttribute($key, $value);
            }
        }
        return $this;
    }

    // Set attribute with casting
    public function setAttribute($key, $value)
    {
        if (isset($this->casts[$key])) {
            $value = $this->castAttribute($key, $value);
        }
        $this->attributes[$key] = $value;
        return $this;
    }

    // Get attribute
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    // Cast attribute based on casts array
    protected function castAttribute($key, $value)
    {
        $castType = $this->casts[$key];
        
        switch ($castType) {
            case 'datetime':
                return $value instanceof Carbon ? $value : Carbon::parse($value);
            case 'integer':
                return (int) $value;
            default:
                return $value;
        }
    }

    // Magic getter
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    // Magic setter
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    // ArrayAccess implementation
    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset): mixed
    {
        return $this->getAttribute($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->setAttribute($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    // JsonSerializable implementation
    public function jsonSerialize(): mixed
    {
        return $this->attributes;
    }

    // Convert to array
    public function toArray()
    {
        return $this->attributes;
    }

    // Get key (ID) for Filament
    public function getKey()
    {
        return $this->getAttribute('id');
    }

    // Get route key name
    public function getRouteKeyName()
    {
        return 'id';
    }

    // Method untuk membuat instance dari file data
    public static function makeFromFile($fileData)
    {
        return new static($fileData);
    }

    // Static query method untuk compatibility
    public static function query()
    {
        return new class {
            public function limit($value) { return $this; }
            public function where($column, $operator = null, $value = null) { return $this; }
            public function get() { return collect(); }
            public function first() { return null; }
            public function count() { return 0; }
        };
    }
} 