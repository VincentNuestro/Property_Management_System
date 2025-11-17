<?php

namespace App\Policies;

use App\Models\LeaseApplication;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\LeaseApplicationStatus;

class LeaseApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::LEASE_APPLICATIONS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeaseApplication $leaseApplication): bool
    {
        return $user->can(Permission::LEASE_APPLICATIONS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::LEASE_APPLICATIONS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeaseApplication $leaseApplication): bool
    {
        // Only allow editing if status is DRAFT or SUBMITTED
        if (!in_array($leaseApplication->status, [LeaseApplicationStatus::DRAFT, LeaseApplicationStatus::SUBMITTED])) {
            return false;
        }

        return $user->can(Permission::LEASE_APPLICATIONS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeaseApplication $leaseApplication): bool
    {
        // Only allow deletion if status is DRAFT
        if ($leaseApplication->status !== LeaseApplicationStatus::DRAFT) {
            return false;
        }

        return $user->can(Permission::LEASE_APPLICATIONS_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeaseApplication $leaseApplication): bool
    {
        return $user->can(Permission::LEASE_APPLICATIONS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeaseApplication $leaseApplication): bool
    {
        return $user->can(Permission::LEASE_APPLICATIONS_DELETE);
    }
}
