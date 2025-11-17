<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\PaymentApplication;
use App\Enums\InvoiceStatus;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PaymentAllocationService
{
    /**
     * Allocate payment to invoices using FIFO (First In, First Out) method
     */
    public function allocatePayment(Payment $payment, ?Collection $specificInvoices = null): void
    {
        if ($payment->status !== PaymentStatus::CLEARED) {
            throw new \Exception('Payment must be cleared before allocation');
        }

        DB::transaction(function () use ($payment, $specificInvoices) {
            // Get invoices to allocate to
            $invoices = $specificInvoices ?? $this->getUnpaidInvoicesForTenant($payment->tenant_id);

            // Calculate available amount to allocate
            $availableAmount = $payment->amount - $payment->amount_applied;

            if ($availableAmount <= 0) {
                return; // Payment fully allocated
            }

            // Apply payment to invoices in FIFO order
            foreach ($invoices as $invoice) {
                if ($availableAmount <= 0) {
                    break;
                }

                $invoiceBalance = $invoice->balance;

                if ($invoiceBalance <= 0) {
                    continue; // Invoice already paid
                }

                // Determine amount to apply to this invoice
                $amountToApply = min($availableAmount, $invoiceBalance);

                // Create payment application record
                PaymentApplication::create([
                    'payment_id' => $payment->id,
                    'invoice_id' => $invoice->id,
                    'amount_applied' => $amountToApply,
                    'applied_date' => now(),
                ]);

                // Update invoice amount_paid and status
                $newAmountPaid = $invoice->amount_paid + $amountToApply;
                $invoice->update([
                    'amount_paid' => $newAmountPaid,
                    'status' => $this->calculateInvoiceStatus($invoice, $newAmountPaid),
                ]);

                // Reduce available amount
                $availableAmount -= $amountToApply;
            }
        });
    }

    /**
     * Get unpaid invoices for a tenant in FIFO order
     */
    protected function getUnpaidInvoicesForTenant(int $tenantId): Collection
    {
        return Invoice::where('tenant_id', $tenantId)
            ->whereIn('status', [
                InvoiceStatus::SENT,
                InvoiceStatus::PARTIALLY_PAID,
                InvoiceStatus::OVERDUE,
            ])
            ->whereColumn('amount_paid', '<', 'total_amount')
            ->orderBy('due_date', 'asc') // FIFO: oldest due date first
            ->orderBy('invoice_date', 'asc')
            ->get();
    }

    /**
     * Calculate invoice status based on payment amount
     */
    protected function calculateInvoiceStatus(Invoice $invoice, float $newAmountPaid): InvoiceStatus
    {
        $totalAmount = $invoice->total_amount;

        if ($newAmountPaid >= $totalAmount) {
            return InvoiceStatus::PAID;
        }

        if ($newAmountPaid > 0) {
            return InvoiceStatus::PARTIALLY_PAID;
        }

        // Check if overdue
        if ($invoice->due_date->isPast()) {
            return InvoiceStatus::OVERDUE;
        }

        return InvoiceStatus::SENT;
    }

    /**
     * Unapply payment from invoices (reverse allocation)
     */
    public function unapplyPayment(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            $applications = $payment->paymentApplications;

            foreach ($applications as $application) {
                $invoice = $application->invoice;

                // Reduce invoice amount_paid
                $newAmountPaid = max(0, $invoice->amount_paid - $application->amount_applied);

                $invoice->update([
                    'amount_paid' => $newAmountPaid,
                    'status' => $this->calculateInvoiceStatus($invoice, $newAmountPaid),
                ]);

                // Delete payment application
                $application->delete();
            }
        });
    }

    /**
     * Reallocate payment (unapply and reapply)
     */
    public function reallocatePayment(Payment $payment, Collection $invoices): void
    {
        DB::transaction(function () use ($payment, $invoices) {
            // First unapply existing allocations
            $this->unapplyPayment($payment);

            // Then apply to specified invoices
            $this->allocatePayment($payment, $invoices);
        });
    }

    /**
     * Get allocation suggestions for a payment
     */
    public function getAllocationSuggestions(Payment $payment): Collection
    {
        $availableAmount = $payment->amount - $payment->amount_applied;
        $invoices = $this->getUnpaidInvoicesForTenant($payment->tenant_id);

        $suggestions = collect();
        $remainingAmount = $availableAmount;

        foreach ($invoices as $invoice) {
            if ($remainingAmount <= 0) {
                break;
            }

            $invoiceBalance = $invoice->balance;
            $suggestedAmount = min($remainingAmount, $invoiceBalance);

            $suggestions->push([
                'invoice' => $invoice,
                'suggested_amount' => $suggestedAmount,
                'will_pay_in_full' => $suggestedAmount >= $invoiceBalance,
            ]);

            $remainingAmount -= $suggestedAmount;
        }

        return $suggestions;
    }
}
