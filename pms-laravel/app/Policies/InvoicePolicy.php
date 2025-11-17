<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use App\Enums\Permission;
use App\Enums\InvoiceStatus;

class InvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::INVOICES_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        return $user->can(Permission::INVOICES_VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::INVOICES_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invoice $invoice): bool
    {
        // Only draft invoices can be edited
        if ($invoice->status !== InvoiceStatus::DRAFT) {
            return false;
        }

        return $user->can(Permission::INVOICES_EDIT);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invoice $invoice): bool
    {
        // Cannot delete invoices with payments
        if ($invoice->amount_paid > 0) {
            return false;
        }

        return $user->can(Permission::INVOICES_DELETE);
    }

    /**
     * Determine whether the user can send the invoice.
     */
    public function send(User $user, Invoice $invoice): bool
    {
        // Only draft invoices can be sent
        if ($invoice->status !== InvoiceStatus::DRAFT) {
            return false;
        }

        return $user->can(Permission::INVOICES_SEND);
    }

    /**
     * Determine whether the user can void the invoice.
     */
    public function void(User $user, Invoice $invoice): bool
    {
        // Cannot void invoices with payments
        if ($invoice->amount_paid > 0) {
            return false;
        }

        // Cannot void already voided/cancelled invoices
        if ($invoice->status === InvoiceStatus::CANCELLED) {
            return false;
        }

        return $user->can(Permission::INVOICES_VOID);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invoice $invoice): bool
    {
        return $user->can(Permission::INVOICES_EDIT);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invoice $invoice): bool
    {
        return $user->can(Permission::INVOICES_DELETE);
    }
}
