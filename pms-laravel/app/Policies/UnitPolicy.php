<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use App\Enums\Permission;

class UnitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::UNITS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Unit $unit): bool
    {
        return $user->can(Permission::UNITS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::UNITS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Unit $unit): bool
    {
        return $user->can(Permission::UNITS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Unit $unit): bool
    {
        // Check if unit has active leases
        $activeLeases = $unit->leaseContracts()
            ->where('status', 'active')
            ->count();

        if ($activeLeases > 0) {
            return false; // Cannot delete unit with active leases
        }

        return $user->can(Permission::UNITS_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Unit $unit): bool
    {
        return $user->can(Permission::UNITS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Unit $unit): bool
    {
        return $user->can(Permission::UNITS_DELETE);
    }
}
