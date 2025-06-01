<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id')
            ->where('model_type', User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }

    public static function getCached()
    {
        return Cache::remember('roles_all', 3600, function () {
            return self::with(['permissions'])
                ->withCount(['users', 'permissions'])
                ->get();
        });
    }

    public static function getCachedByName($name)
    {
        return Cache::remember("role_name_{$name}", 3600, function () use ($name) {
            return self::where('name', $name)
                ->with(['permissions'])
                ->withCount(['users', 'permissions'])
                ->first();
        });
    }

    public static function getCachedWithUsers()
    {
        return Cache::remember('roles_with_users', 3600, function () {
            return self::with(['users', 'permissions'])
                ->withCount(['users', 'permissions'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($role) {
            Cache::forget('roles_all');
            Cache::forget("role_name_{$role->name}");
            Cache::forget('roles_with_users');
        });

        static::deleted(function ($role) {
            Cache::forget('roles_all');
            Cache::forget("role_name_{$role->name}");
            Cache::forget('roles_with_users');
        });
    }
} 