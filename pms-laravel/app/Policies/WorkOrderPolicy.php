<?php

namespace App\Policies;

use App\Models\WorkOrder;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\WorkOrderStatus;

class WorkOrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::WORK_ORDERS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WorkOrder $workOrder): bool
    {
        return $user->can(Permission::WORK_ORDERS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::WORK_ORDERS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WorkOrder $workOrder): bool
    {
        // Only allow updating if status is DRAFT, SCHEDULED, or IN_PROGRESS
        if (!in_array($workOrder->status, [WorkOrderStatus::DRAFT, WorkOrderStatus::SCHEDULED, WorkOrderStatus::IN_PROGRESS])) {
            return false;
        }

        return $user->can(Permission::WORK_ORDERS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorkOrder $workOrder): bool
    {
        // Only allow deletion if status is DRAFT
        if ($workOrder->status !== WorkOrderStatus::DRAFT) {
            return false;
        }

        return $user->can(Permission::WORK_ORDERS_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WorkOrder $workOrder): bool
    {
        return $user->can(Permission::WORK_ORDERS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WorkOrder $workOrder): bool
    {
        return $user->can(Permission::WORK_ORDERS_DELETE);
    }

    /**
     * Determine whether the user can schedule the work order.
     */
    public function schedule(User $user, WorkOrder $workOrder): bool
    {
        return $user->can(Permission::WORK_ORDERS_EDIT);
    }

    /**
     * Determine whether the user can start the work order.
     */
    public function start(User $user, WorkOrder $workOrder): bool
    {
        return $user->can(Permission::WORK_ORDERS_EDIT);
    }

    /**
     * Determine whether the user can complete the work order.
     */
    public function complete(User $user, WorkOrder $workOrder): bool
    {
        return $user->can(Permission::WORK_ORDERS_COMPLETE);
    }
}
