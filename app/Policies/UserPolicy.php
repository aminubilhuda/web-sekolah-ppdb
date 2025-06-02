<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        
        if ($user->hasRole('guru')) {
            return $user->hasPermissionTo('view-students');
        }
        
        return false;
    }

    public function view(User $user, User $model): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        
        if ($user->hasRole('guru') && $model->hasRole('siswa')) {
            return $user->hasPermissionTo('view-students');
        }
        
        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-users');
    }

    public function update(User $user, User $model): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }
        
        if ($user->hasRole('guru') && $model->hasRole('siswa')) {
            return $user->hasPermissionTo('edit-students');
        }
        
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }
        
        return $user->hasPermissionTo('delete-users');
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasPermissionTo('restore-users');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('force-delete-users');
    }
}