<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ProductPresentation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ProductPresentationPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProductPresentation');
    }

    public function view(AuthUser $authUser, ProductPresentation $productPresentation): bool
    {
        return $authUser->can('View:ProductPresentation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProductPresentation');
    }

    public function update(AuthUser $authUser, ProductPresentation $productPresentation): bool
    {
        return $authUser->can('Update:ProductPresentation');
    }

    public function delete(AuthUser $authUser, ProductPresentation $productPresentation): bool
    {
        return $authUser->can('Delete:ProductPresentation');
    }

    public function restore(AuthUser $authUser, ProductPresentation $productPresentation): bool
    {
        return $authUser->can('Restore:ProductPresentation');
    }

    public function forceDelete(AuthUser $authUser, ProductPresentation $productPresentation): bool
    {
        return $authUser->can('ForceDelete:ProductPresentation');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProductPresentation');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProductPresentation');
    }

    public function replicate(AuthUser $authUser, ProductPresentation $productPresentation): bool
    {
        return $authUser->can('Replicate:ProductPresentation');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProductPresentation');
    }
}
