<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Status');
    }

    public function view(AuthUser $authUser, Status $status): bool
    {
        return $authUser->can('View:Status');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Status');
    }

    public function update(AuthUser $authUser, Status $status): bool
    {
        return $authUser->can('Update:Status');
    }

    public function delete(AuthUser $authUser, Status $status): bool
    {
        return $authUser->can('Delete:Status');
    }

    public function restore(AuthUser $authUser, Status $status): bool
    {
        return $authUser->can('Restore:Status');
    }

    public function forceDelete(AuthUser $authUser, Status $status): bool
    {
        return $authUser->can('ForceDelete:Status');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Status');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Status');
    }

    public function replicate(AuthUser $authUser, Status $status): bool
    {
        return $authUser->can('Replicate:Status');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Status');
    }

}