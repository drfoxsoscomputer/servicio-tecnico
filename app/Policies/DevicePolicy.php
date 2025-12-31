<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Device;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Device');
    }

    public function view(AuthUser $authUser, Device $device): bool
    {
        return $authUser->can('View:Device');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Device');
    }

    public function update(AuthUser $authUser, Device $device): bool
    {
        return $authUser->can('Update:Device');
    }

    public function delete(AuthUser $authUser, Device $device): bool
    {
        return $authUser->can('Delete:Device');
    }

    public function restore(AuthUser $authUser, Device $device): bool
    {
        return $authUser->can('Restore:Device');
    }

    public function forceDelete(AuthUser $authUser, Device $device): bool
    {
        return $authUser->can('ForceDelete:Device');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Device');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Device');
    }

    public function replicate(AuthUser $authUser, Device $device): bool
    {
        return $authUser->can('Replicate:Device');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Device');
    }

}