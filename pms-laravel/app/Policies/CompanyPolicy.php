<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use App\Enums\Permission;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::COMPANIES_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        return $user->can(Permission::COMPANIES_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::COMPANIES_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): bool
    {
        return $user->can(Permission::COMPANIES_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): bool
    {
        // Check if company has tenants
        if ($company->tenants()->count() > 0) {
            return false; // Cannot delete company with tenants
        }

        return $user->can(Permission::COMPANIES_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Company $company): bool
    {
        return $user->can(Permission::COMPANIES_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Company $company): bool
    {
        return $user->can(Permission::COMPANIES_DELETE);
    }
}
