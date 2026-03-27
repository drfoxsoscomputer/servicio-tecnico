<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\DeviceType;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeviceTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DeviceType');
    }

    public function view(AuthUser $authUser, DeviceType $deviceType): bool
    {
        return $authUser->can('View:DeviceType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DeviceType');
    }

    public function update(AuthUser $authUser, DeviceType $deviceType): bool
    {
        return $authUser->can('Update:DeviceType');
    }

    public function delete(AuthUser $authUser, DeviceType $deviceType): bool
    {
        return $authUser->can('Delete:DeviceType');
    }

    public function restore(AuthUser $authUser, DeviceType $deviceType): bool
    {
        return $authUser->can('Restore:DeviceType');
    }

    public function forceDelete(AuthUser $authUser, DeviceType $deviceType): bool
    {
        return $authUser->can('ForceDelete:DeviceType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DeviceType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DeviceType');
    }

    public function replicate(AuthUser $authUser, DeviceType $deviceType): bool
    {
        return $authUser->can('Replicate:DeviceType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DeviceType');
    }

}