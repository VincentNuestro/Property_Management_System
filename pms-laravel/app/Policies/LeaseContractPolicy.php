<?php

namespace App\Policies;

use App\Models\LeaseContract;
use App\Models\User;
use App\Enums\Permission;

class LeaseContractPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::LEASE_CONTRACTS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeaseContract $leaseContract): bool
    {
        return $user->can(Permission::LEASE_CONTRACTS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::LEASE_CONTRACTS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeaseContract $leaseContract): bool
    {
        return $user->can(Permission::LEASE_CONTRACTS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeaseContract $leaseContract): bool
    {
        return $user->can(Permission::LEASE_CONTRACTS_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeaseContract $leaseContract): bool
    {
        return $user->can(Permission::LEASE_CONTRACTS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeaseContract $leaseContract): bool
    {
        return $user->can(Permission::LEASE_CONTRACTS_DELETE);
    }
}
