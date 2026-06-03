<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AttributeValue;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class AttributeValuePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AttributeValue');
    }

    public function view(AuthUser $authUser, AttributeValue $attributeValue): bool
    {
        return $authUser->can('View:AttributeValue');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AttributeValue');
    }

    public function update(AuthUser $authUser, AttributeValue $attributeValue): bool
    {
        return $authUser->can('Update:AttributeValue');
    }

    public function delete(AuthUser $authUser, AttributeValue $attributeValue): bool
    {
        return $authUser->can('Delete:AttributeValue');
    }

    public function restore(AuthUser $authUser, AttributeValue $attributeValue): bool
    {
        return $authUser->can('Restore:AttributeValue');
    }

    public function forceDelete(AuthUser $authUser, AttributeValue $attributeValue): bool
    {
        return $authUser->can('ForceDelete:AttributeValue');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AttributeValue');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AttributeValue');
    }

    public function replicate(AuthUser $authUser, AttributeValue $attributeValue): bool
    {
        return $authUser->can('Replicate:AttributeValue');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AttributeValue');
    }
}
