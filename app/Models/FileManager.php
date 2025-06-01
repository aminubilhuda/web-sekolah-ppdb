<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FileManager extends Model
{
    // Dummy model untuk File Manager
    // Tidak menggunakan database table
    
    protected $fillable = ['name', 'path', 'size', 'type', 'modified'];
    
    // Disable database table
    protected $table = null;
    
    // Disable timestamps
    public $timestamps = false;
    
    // Override untuk mencegah save/delete operations
    public function save(array $options = [])
    {
        return true;
    }
    
    public function delete()
    {
        return true;
    }
    
    public static function all($columns = ['*'])
    {
        return new Collection();
    }

    public static function find($id, $columns = ['*'])
    {
        // Return null for individual record lookups
        return null;
    }
    
    public static function findOrFail($id, $columns = ['*'])
    {
        return new static(['id' => $id]);
    }
    
    public static function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        return new static();
    }
    
    public function newQuery()
    {
        // Return a mock query builder that doesn't execute
        return new class {
            public function where(...$args) { return $this; }
            public function limit(...$args) { return $this; }
            public function first() { return null; }
            public function get() { return new Collection(); }
            public function find($id) { return null; }
        };
    }
    
    // Override getAttribute to prevent database access
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }
    
    public static function fromArray($data)
    {
        $instance = new static();
        
        // Set attributes directly
        foreach ($data as $key => $value) {
            $instance->attributes[$key] = $value;
        }
        
        // Mark as existing
        $instance->exists = true;
        $instance->syncOriginal();
        
        return $instance;
    }
    
    // Override to prevent database connection
    public function getConnectionName()
    {
        return null;
    }
    
    public function getConnection()
    {
        return null;
    }
}
