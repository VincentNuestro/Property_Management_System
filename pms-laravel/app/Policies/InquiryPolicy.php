<?php

namespace App\Policies;

use App\Models\Inquiry;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\InquiryStatus;

class InquiryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::INQUIRIES_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inquiry $inquiry): bool
    {
        return $user->can(Permission::INQUIRIES_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::INQUIRIES_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inquiry $inquiry): bool
    {
        // Only allow editing if status is NEW or CONTACTED
        if (!in_array($inquiry->status, [InquiryStatus::NEW, InquiryStatus::CONTACTED])) {
            return false;
        }

        return $user->can(Permission::INQUIRIES_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inquiry $inquiry): bool
    {
        // Only allow deleting if status is NEW, LOST
        if (!in_array($inquiry->status, [InquiryStatus::NEW, InquiryStatus::LOST])) {
            return false;
        }

        return $user->can(Permission::INQUIRIES_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inquiry $inquiry): bool
    {
        return $user->can(Permission::INQUIRIES_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inquiry $inquiry): bool
    {
        return $user->can(Permission::INQUIRIES_DELETE);
    }
}
