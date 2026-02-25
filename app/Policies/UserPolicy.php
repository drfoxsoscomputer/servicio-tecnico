<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:User');
    }

    public function view(AuthUser $authUser, User $user): bool
    {
        if ($user->hasRole('super_admin') && !$authUser->hasRole('super_admin')) {
            return false;
        }
        return $authUser->can('View:User');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:User');
    }

    public function update(AuthUser $authUser, User $user): bool
    {
        if ($user->hasRole('super_admin') && !$authUser->hasRole('super_admin')) {
            return false;
        }
        return $authUser->can('Update:User');
    }

    public function delete(AuthUser $authUser, User $user): bool
    {
        if ($user->hasRole('super_admin') && ! $authUser->hasRole('super_admin')) {
            return false;
        }
        return $authUser->can('Delete:User');
    }

    public function restore(AuthUser $authUser, User $user): bool
    {
        if ($user->hasRole('super_admin') && !$authUser->hasRole('super_admin')) {
            return false;
        }
        return $authUser->can('Restore:User');
    }

    public function forceDelete(AuthUser $authUser, User $user): bool
    {
        if ($user->hasRole('super_admin') && !$authUser->hasRole('super_admin')) {
            return false;
        }
        return $authUser->can('ForceDelete:User');
    }

    public function forceDeleteAny(AuthUser $authUser, User $user): bool
    {
        if ($user->hasRole('super_admin') && !$authUser->hasRole('super_admin')) {
            return false;
        }
        return $authUser->can('ForceDeleteAny:User');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    public function replicate(AuthUser $authUser): bool
    {
        return $authUser->can('Replicate:User');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }
}
