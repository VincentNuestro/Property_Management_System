<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\PaymentStatus;

class PaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::PAYMENTS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): bool
    {
        return $user->can(Permission::PAYMENTS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::PAYMENTS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payment $payment): bool
    {
        // Only pending payments can be edited
        if ($payment->status !== PaymentStatus::PENDING) {
            return false;
        }

        return $user->can(Permission::PAYMENTS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payment $payment): bool
    {
        // Cannot delete payments with applications
        if ($payment->amount_applied > 0) {
            return false;
        }

        return $user->can(Permission::PAYMENTS_DELETE);
    }

    /**
     * Determine whether the user can allocate the payment.
     */
    public function allocate(User $user, Payment $payment): bool
    {
        // Only cleared payments can be allocated
        if ($payment->status !== PaymentStatus::CLEARED) {
            return false;
        }

        return $user->can(Permission::PAYMENTS_APPLY);
    }

    /**
     * Determine whether the user can void the payment.
     */
    public function void(User $user, Payment $payment): bool
    {
        // Cannot void payments with applications
        if ($payment->amount_applied > 0) {
            return false;
        }

        // Cannot void already voided/cancelled payments
        if ($payment->status === PaymentStatus::CANCELLED) {
            return false;
        }

        return $user->can(Permission::PAYMENTS_VOID);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Payment $payment): bool
    {
        return $user->can(Permission::PAYMENTS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        return $user->can(Permission::PAYMENTS_DELETE);
    }
}
