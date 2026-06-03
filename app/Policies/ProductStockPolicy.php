<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ProductStock;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ProductStockPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProductStock');
    }

    public function view(AuthUser $authUser, ProductStock $productStock): bool
    {
        return $authUser->can('View:ProductStock');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProductStock');
    }

    public function update(AuthUser $authUser, ProductStock $productStock): bool
    {
        return $authUser->can('Update:ProductStock');
    }

    public function delete(AuthUser $authUser, ProductStock $productStock): bool
    {
        return $authUser->can('Delete:ProductStock');
    }

    public function restore(AuthUser $authUser, ProductStock $productStock): bool
    {
        return $authUser->can('Restore:ProductStock');
    }

    public function forceDelete(AuthUser $authUser, ProductStock $productStock): bool
    {
        return $authUser->can('ForceDelete:ProductStock');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProductStock');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProductStock');
    }

    public function replicate(AuthUser $authUser, ProductStock $productStock): bool
    {
        return $authUser->can('Replicate:ProductStock');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProductStock');
    }
}
