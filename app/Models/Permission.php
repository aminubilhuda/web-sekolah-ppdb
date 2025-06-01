<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_permissions', 'permission_id', 'model_id')
            ->where('model_type', User::class);
    }

    public static function getCached()
    {
        return Cache::remember('permissions_all', 3600, function () {
            return self::with(['roles'])
                ->withCount(['roles', 'users'])
                ->get();
        });
    }

    public static function getCachedByName($name)
    {
        return Cache::remember("permission_name_{$name}", 3600, function () use ($name) {
            return self::where('name', $name)
                ->with(['roles'])
                ->withCount(['roles', 'users'])
                ->first();
        });
    }

    public static function getCachedByRole($roleName)
    {
        return Cache::remember("permissions_role_{$roleName}", 3600, function () use ($roleName) {
            return self::whereHas('roles', function ($query) use ($roleName) {
                $query->where('name', $roleName);
            })
            ->with(['roles'])
            ->withCount(['roles', 'users'])
            ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($permission) {
            Cache::forget('permissions_all');
            Cache::forget("permission_name_{$permission->name}");
            foreach ($permission->roles as $role) {
                Cache::forget("permissions_role_{$role->name}");
            }
        });

        static::deleted(function ($permission) {
            Cache::forget('permissions_all');
            Cache::forget("permission_name_{$permission->name}");
            foreach ($permission->roles as $role) {
                Cache::forget("permissions_role_{$role->name}");
            }
        });
    }
} 