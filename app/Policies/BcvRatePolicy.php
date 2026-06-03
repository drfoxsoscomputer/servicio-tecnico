<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BcvRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class BcvRatePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BcvRate');
    }

    public function view(AuthUser $authUser, BcvRate $bcvRate): bool
    {
        return $authUser->can('View:BcvRate');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BcvRate');
    }

    public function update(AuthUser $authUser, BcvRate $bcvRate): bool
    {
        return $authUser->can('Update:BcvRate');
    }

    public function delete(AuthUser $authUser, BcvRate $bcvRate): bool
    {
        return $authUser->can('Delete:BcvRate');
    }

    public function restore(AuthUser $authUser, BcvRate $bcvRate): bool
    {
        return $authUser->can('Restore:BcvRate');
    }

    public function forceDelete(AuthUser $authUser, BcvRate $bcvRate): bool
    {
        return $authUser->can('ForceDelete:BcvRate');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BcvRate');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BcvRate');
    }

    public function replicate(AuthUser $authUser, BcvRate $bcvRate): bool
    {
        return $authUser->can('Replicate:BcvRate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BcvRate');
    }

}