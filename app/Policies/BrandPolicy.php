<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Brand;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Brand');
    }

    public function view(AuthUser $authUser, Brand $brand): bool
    {
        return $authUser->can('View:Brand');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Brand');
    }

    public function update(AuthUser $authUser, Brand $brand): bool
    {
        return $authUser->can('Update:Brand');
    }

    public function delete(AuthUser $authUser, Brand $brand): bool
    {
        return $authUser->can('Delete:Brand');
    }

    public function restore(AuthUser $authUser, Brand $brand): bool
    {
        return $authUser->can('Restore:Brand');
    }

    public function forceDelete(AuthUser $authUser, Brand $brand): bool
    {
        return $authUser->can('ForceDelete:Brand');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Brand');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Brand');
    }

    public function replicate(AuthUser $authUser, Brand $brand): bool
    {
        return $authUser->can('Replicate:Brand');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Brand');
    }

}