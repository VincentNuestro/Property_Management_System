<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\LeaseStatus;

class TenantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::TENANTS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tenant $tenant): bool
    {
        return $user->can(Permission::TENANTS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::TENANTS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tenant $tenant): bool
    {
        return $user->can(Permission::TENANTS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tenant $tenant): bool
    {
        // Check if tenant has active leases
        $activeLeases = $tenant->leaseContracts()
            ->where('status', LeaseStatus::ACTIVE)
            ->count();

        if ($activeLeases > 0) {
            return false; // Cannot delete tenant with active leases
        }

        return $user->can(Permission::TENANTS_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tenant $tenant): bool
    {
        return $user->can(Permission::TENANTS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tenant $tenant): bool
    {
        return $user->can(Permission::TENANTS_DELETE);
    }
}
