<?php

namespace App\Policies;

use App\Models\MaintenanceRequest;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\MaintenanceRequestStatus;

class MaintenanceRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::MAINTENANCE_REQUESTS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->can(Permission::MAINTENANCE_REQUESTS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::MAINTENANCE_REQUESTS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Cannot update completed or cancelled requests
        if (in_array($maintenanceRequest->status, [
            MaintenanceRequestStatus::COMPLETED,
            MaintenanceRequestStatus::CANCELLED
        ])) {
            return false;
        }

        return $user->can(Permission::MAINTENANCE_REQUESTS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Only allow deleting SUBMITTED requests
        if ($maintenanceRequest->status !== MaintenanceRequestStatus::SUBMITTED) {
            return false;
        }

        return $user->can(Permission::MAINTENANCE_REQUESTS_DELETE);
    }

    /**
     * Determine whether the user can assign the maintenance request.
     */
    public function assign(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Cannot assign completed or cancelled requests
        if (in_array($maintenanceRequest->status, [
            MaintenanceRequestStatus::COMPLETED,
            MaintenanceRequestStatus::CANCELLED
        ])) {
            return false;
        }

        return $user->can(Permission::MAINTENANCE_REQUESTS_ASSIGN);
    }

    /**
     * Determine whether the user can complete the maintenance request.
     */
    public function complete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Cannot complete already completed or cancelled requests
        if (in_array($maintenanceRequest->status, [
            MaintenanceRequestStatus::COMPLETED,
            MaintenanceRequestStatus::CANCELLED
        ])) {
            return false;
        }

        return $user->can(Permission::MAINTENANCE_REQUESTS_COMPLETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->can(Permission::MAINTENANCE_REQUESTS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->can(Permission::MAINTENANCE_REQUESTS_DELETE);
    }
}
