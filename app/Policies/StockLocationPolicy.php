<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\StockLocation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class StockLocationPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StockLocation');
    }

    public function view(AuthUser $authUser, StockLocation $stockLocation): bool
    {
        return $authUser->can('View:StockLocation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StockLocation');
    }

    public function update(AuthUser $authUser, StockLocation $stockLocation): bool
    {
        return $authUser->can('Update:StockLocation');
    }

    public function delete(AuthUser $authUser, StockLocation $stockLocation): bool
    {
        return $authUser->can('Delete:StockLocation');
    }

    public function restore(AuthUser $authUser, StockLocation $stockLocation): bool
    {
        return $authUser->can('Restore:StockLocation');
    }

    public function forceDelete(AuthUser $authUser, StockLocation $stockLocation): bool
    {
        return $authUser->can('ForceDelete:StockLocation');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StockLocation');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StockLocation');
    }

    public function replicate(AuthUser $authUser, StockLocation $stockLocation): bool
    {
        return $authUser->can('Replicate:StockLocation');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StockLocation');
    }
}
