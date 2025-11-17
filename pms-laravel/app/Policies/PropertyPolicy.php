<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use App\Enums\Permission;

class PropertyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::PROPERTIES_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Property $property): bool
    {
        return $user->can(Permission::PROPERTIES_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::PROPERTIES_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Property $property): bool
    {
        return $user->can(Permission::PROPERTIES_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Property $property): bool
    {
        // Check if property has related data
        if ($property->units()->count() > 0) {
            return false; // Cannot delete property with units
        }

        return $user->can(Permission::PROPERTIES_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Property $property): bool
    {
        return $user->can(Permission::PROPERTIES_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Property $property): bool
    {
        return $user->can(Permission::PROPERTIES_DELETE);
    }
}
