<?php

namespace App\Services;

use App\Models\LeaseContract;
use App\Models\Invoice;
use App\Models\InvoiceLineItem;
use App\Models\ChargeType;
use App\Enums\InvoiceStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BillingService
{
    /**
     * Generate invoice for a lease contract
     */
    public function generateInvoice(LeaseContract $contract, Carbon $periodStart, Carbon $periodEnd): Invoice
    {
        return DB::transaction(function () use ($contract, $periodStart, $periodEnd) {
            // Calculate invoice number
            $invoiceNumber = $this->generateInvoiceNumber();

            // Calculate due date based on payment terms
            $invoiceDate = now();
            $dueDate = $invoiceDate->copy()->addDays($contract->payment_terms_days ?? config('pms.business.default_payment_terms_days'));

            // Create invoice
            $invoice = Invoice::create([
                'property_id' => $contract->property_id,
                'tenant_id' => $contract->tenant_id,
                'lease_contract_id' => $contract->id,
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'subtotal' => 0,
                'tax_amount' => 0,
                'total_amount' => 0,
                'amount_paid' => 0,
                'status' => InvoiceStatus::DRAFT,
            ]);

            // Add rental charges
            $this->addRentalCharges($invoice, $contract, $periodStart, $periodEnd);

            // Add recurring contract charges
            $this->addRecurringCharges($invoice, $contract);

            // Calculate totals
            $this->calculateInvoiceTotals($invoice);

            // Mark as sent
            $invoice->update(['status' => InvoiceStatus::SENT]);

            return $invoice->fresh();
        });
    }

    /**
     * Add rental charges with proration if needed
     */
    protected function addRentalCharges(Invoice $invoice, LeaseContract $contract, Carbon $periodStart, Carbon $periodEnd): void
    {
        $rentChargeType = ChargeType::where('code', 'RENT')->first();
        $duesChargeType = ChargeType::where('code', 'ASSOC_DUES')->first();

        foreach ($contract->units as $unit) {
            $monthlyRent = $unit->pivot->monthly_rent;
            $associationDues = $unit->pivot->association_dues;

            // Check if proration is needed
            $proratedRent = $this->calculateProratedAmount(
                $monthlyRent,
                $periodStart,
                $periodEnd,
                $contract->start_date,
                $contract->end_date
            );

            $proratedDues = $this->calculateProratedAmount(
                $associationDues,
                $periodStart,
                $periodEnd,
                $contract->start_date,
                $contract->end_date
            );

            // Add rent line item
            if ($proratedRent > 0) {
                InvoiceLineItem::create([
                    'invoice_id' => $invoice->id,
                    'charge_type_id' => $rentChargeType->id,
                    'description' => "Rent - {$unit->unit_number} ({$periodStart->format('M d, Y')} - {$periodEnd->format('M d, Y')})",
                    'quantity' => 1,
                    'unit_price' => $proratedRent,
                    'amount' => $proratedRent,
                    'is_taxable' => $rentChargeType->is_taxable,
                    'tax_rate' => 0,
                    'tax_amount' => 0,
                ]);
            }

            // Add association dues line item
            if ($proratedDues > 0) {
                InvoiceLineItem::create([
                    'invoice_id' => $invoice->id,
                    'charge_type_id' => $duesChargeType->id,
                    'description' => "Association Dues - {$unit->unit_number} ({$periodStart->format('M d, Y')} - {$periodEnd->format('M d, Y')})",
                    'quantity' => 1,
                    'unit_price' => $proratedDues,
                    'amount' => $proratedDues,
                    'is_taxable' => $duesChargeType->is_taxable,
                    'tax_rate' => 0,
                    'tax_amount' => 0,
                ]);
            }
        }
    }

    /**
     * Calculate prorated amount based on actual days
     */
    public function calculateProratedAmount(
        float $monthlyAmount,
        Carbon $periodStart,
        Carbon $periodEnd,
        Carbon $leaseStart,
        Carbon $leaseEnd
    ): float {
        // Determine the effective period (intersection of billing period and lease period)
        $effectiveStart = $periodStart->max($leaseStart);
        $effectiveEnd = $periodEnd->min($leaseEnd);

        // If no overlap, return 0
        if ($effectiveEnd->lt($effectiveStart)) {
            return 0;
        }

        // Calculate days in the billing period
        $daysInBillingPeriod = $periodStart->diffInDays($periodEnd) + 1;

        // Calculate actual days to charge
        $daysToCharge = $effectiveStart->diffInDays($effectiveEnd) + 1;

        // If full period, return full amount
        if ($daysToCharge >= $daysInBillingPeriod) {
            return $monthlyAmount;
        }

        // Calculate proration: (monthly amount / days in month) * days to charge
        $daysInMonth = $periodStart->daysInMonth;
        $dailyRate = $monthlyAmount / $daysInMonth;
        $proratedAmount = $dailyRate * $daysToCharge;

        return round($proratedAmount, 2);
    }

    /**
     * Add recurring contract charges
     */
    protected function addRecurringCharges(Invoice $invoice, LeaseContract $contract): void
    {
        $recurringCharges = $contract->contractCharges()->where('is_recurring', true)->get();

        foreach ($recurringCharges as $charge) {
            InvoiceLineItem::create([
                'invoice_id' => $invoice->id,
                'charge_type_id' => $charge->charge_type_id,
                'description' => $charge->chargeType->name,
                'quantity' => 1,
                'unit_price' => $charge->amount,
                'amount' => $charge->amount,
                'is_taxable' => $charge->chargeType->is_taxable,
                'tax_rate' => 0,
                'tax_amount' => 0,
            ]);
        }
    }

    /**
     * Calculate invoice totals
     */
    protected function calculateInvoiceTotals(Invoice $invoice): void
    {
        $lineItems = $invoice->lineItems;

        $subtotal = $lineItems->sum('amount');
        $taxAmount = $lineItems->sum('tax_amount');
        $total = $subtotal + $taxAmount;

        $invoice->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $total,
        ]);
    }

    /**
     * Generate unique invoice number
     */
    protected function generateInvoiceNumber(): string
    {
        $prefix = config('pms.numbering.invoice_prefix', 'INV');
        $year = now()->year;
        $month = now()->format('m');

        // Get last invoice number for this month
        $lastInvoice = Invoice::whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice && preg_match("/{$prefix}-{$year}{$month}-(\\d+)/", $lastInvoice->invoice_number, $matches)) {
            $sequence = intval($matches[1]) + 1;
        } else {
            $sequence = 1;
        }

        return sprintf('%s-%s%s-%05d', $prefix, $year, $month, $sequence);
    }

    /**
     * Apply rent escalation to a lease contract
     */
    public function applyRentEscalation(LeaseContract $contract): void
    {
        if (!$contract->escalation_rate || $contract->escalation_rate <= 0) {
            return;
        }

        DB::transaction(function () use ($contract) {
            // Calculate new rates
            $escalationMultiplier = 1 + ($contract->escalation_rate / 100);

            foreach ($contract->units as $unit) {
                $currentRent = $unit->pivot->monthly_rent;
                $currentDues = $unit->pivot->association_dues;

                $newRent = round($currentRent * $escalationMultiplier, 2);
                $newDues = round($currentDues * $escalationMultiplier, 2);

                // Update pivot table
                $contract->units()->updateExistingPivot($unit->id, [
                    'monthly_rent' => $newRent,
                    'association_dues' => $newDues,
                ]);
            }

            // Calculate next escalation date
            $nextEscalationDate = $contract->next_escalation_date
                ->addMonths($contract->escalation_frequency_months);

            $contract->update([
                'next_escalation_date' => $nextEscalationDate,
            ]);
        });
    }
}
