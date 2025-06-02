<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'role', // Legacy role field
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'user_id');
    }

    public static function getCached()
    {
        return Cache::remember('users_all', 3600, function () {
            return self::with(['roles'])
                ->withCount(['pengumuman'])
                ->get();
        });
    }

    public static function getCachedActive()
    {
        return Cache::remember('users_active', 3600, function () {
            return self::where('status', 'active')
                ->with(['roles'])
                ->withCount(['pengumuman'])
                ->get();
        });
    }

    public static function getCachedByRole($roleName)
    {
        return Cache::remember("users_role_{$roleName}", 3600, function () use ($roleName) {
            return self::role($roleName)
                ->where('status', 'active')
                ->with(['roles'])
                ->withCount(['pengumuman'])
                ->get();
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($user) {
            Cache::forget('users_all');
            Cache::forget('users_active');
            foreach ($user->roles as $role) {
                Cache::forget("users_role_{$role->name}");
            }
        });

        static::deleted(function ($user) {
            Cache::forget('users_all');
            Cache::forget('users_active');
            foreach ($user->roles as $role) {
                Cache::forget("users_role_{$role->name}");
            }
        });
    }

    /**
     * Sync the legacy role field with Spatie roles
     */
    public function syncLegacyRole()
    {
        if ($this->role && !$this->hasRole($this->role)) {
            $this->assignRole($this->role);
        }
    }

    /**
     * Override the save method to sync legacy role
     */
    public function save(array $options = [])
    {
        $saved = parent::save($options);
        $this->syncLegacyRole();
        return $saved;
    }

    /**
     * Get all permissions for the user, including inherited ones from roles
     */
    public function getAllPermissions()
    {
        return $this->getAllPermissions();
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(...$permissions)
    {
        return $this->hasAnyPermission($permissions);
    }

    /**
     * Get user's highest role
     */
    public function getHighestRole()
    {
        $roleHierarchy = [
            'super-admin' => 5,
            'admin' => 4,
            'staff' => 3,
            'guru' => 2,
            'siswa' => 1
        ];

        return $this->roles
            ->sortByDesc(fn($role) => $roleHierarchy[$role->name] ?? 0)
            ->first();
    }
}