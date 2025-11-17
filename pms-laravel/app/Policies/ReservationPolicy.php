<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\ReservationStatus;

class ReservationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::RESERVATIONS_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->can(Permission::RESERVATIONS_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::RESERVATIONS_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        // Can only update active reservations
        if ($reservation->status !== ReservationStatus::ACTIVE) {
            return false;
        }

        return $user->can(Permission::RESERVATIONS_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation): bool
    {
        // Cannot delete converted or cancelled reservations
        if (in_array($reservation->status, [ReservationStatus::CONVERTED, ReservationStatus::CANCELLED])) {
            return false;
        }

        return $user->can(Permission::RESERVATIONS_DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        return $user->can(Permission::RESERVATIONS_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        return $user->can(Permission::RESERVATIONS_DELETE);
    }

    /**
     * Determine whether the user can convert the reservation to a lease application.
     */
    public function convert(User $user, Reservation $reservation): bool
    {
        // Can only convert active reservations
        if ($reservation->status !== ReservationStatus::ACTIVE) {
            return false;
        }

        return $user->can(Permission::RESERVATIONS_CONVERT);
    }
}
