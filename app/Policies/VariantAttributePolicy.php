<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\VariantAttribute;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class VariantAttributePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:VariantAttribute');
    }

    public function view(AuthUser $authUser, VariantAttribute $variantAttribute): bool
    {
        return $authUser->can('View:VariantAttribute');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:VariantAttribute');
    }

    public function update(AuthUser $authUser, VariantAttribute $variantAttribute): bool
    {
        return $authUser->can('Update:VariantAttribute');
    }

    public function delete(AuthUser $authUser, VariantAttribute $variantAttribute): bool
    {
        return $authUser->can('Delete:VariantAttribute');
    }

    public function restore(AuthUser $authUser, VariantAttribute $variantAttribute): bool
    {
        return $authUser->can('Restore:VariantAttribute');
    }

    public function forceDelete(AuthUser $authUser, VariantAttribute $variantAttribute): bool
    {
        return $authUser->can('ForceDelete:VariantAttribute');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:VariantAttribute');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:VariantAttribute');
    }

    public function replicate(AuthUser $authUser, VariantAttribute $variantAttribute): bool
    {
        return $authUser->can('Replicate:VariantAttribute');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:VariantAttribute');
    }
}
