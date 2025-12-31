<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ServiceOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceOrderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ServiceOrder');
    }

    public function view(AuthUser $authUser, ServiceOrder $serviceOrder): bool
    {
        return $authUser->can('View:ServiceOrder');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ServiceOrder');
    }

    public function update(AuthUser $authUser, ServiceOrder $serviceOrder): bool
    {
        return $authUser->can('Update:ServiceOrder');
    }

    public function delete(AuthUser $authUser, ServiceOrder $serviceOrder): bool
    {
        return $authUser->can('Delete:ServiceOrder');
    }

    public function restore(AuthUser $authUser, ServiceOrder $serviceOrder): bool
    {
        return $authUser->can('Restore:ServiceOrder');
    }

    public function forceDelete(AuthUser $authUser, ServiceOrder $serviceOrder): bool
    {
        return $authUser->can('ForceDelete:ServiceOrder');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ServiceOrder');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ServiceOrder');
    }

    public function replicate(AuthUser $authUser, ServiceOrder $serviceOrder): bool
    {
        return $authUser->can('Replicate:ServiceOrder');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ServiceOrder');
    }

}