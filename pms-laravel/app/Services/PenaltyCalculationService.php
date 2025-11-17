<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Penalty;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PenaltyCalculationService
{
    /**
     * Calculate and create penalties for overdue invoices
     */
    public function calculatePenalties(?Carbon $asOfDate = null): Collection
    {
        $asOfDate = $asOfDate ?? now();
        $penalties = collect();

        // Get all overdue invoices
        $overdueInvoices = $this->getOverdueInvoices($asOfDate);

        foreach ($overdueInvoices as $invoice) {
            $penalty = $this->calculateInvoicePenalty($invoice, $asOfDate);

            if ($penalty) {
                $penalties->push($penalty);
            }
        }

        return $penalties;
    }

    /**
     * Calculate penalty for a single invoice
     */
    public function calculateInvoicePenalty(Invoice $invoice, ?Carbon $asOfDate = null): ?Penalty
    {
        $asOfDate = $asOfDate ?? now();

        // Check if invoice is overdue
        if (!$invoice->is_overdue) {
            return null;
        }

        // Get grace period from config
        $gracePeriodDays = config('pms.business.penalty_grace_period_days', 5);

        // Calculate days overdue after grace period
        $daysOverdueWithGrace = $invoice->days_overdue - $gracePeriodDays;

        if ($daysOverdueWithGrace <= 0) {
            return null; // Still within grace period
        }

        // Check if penalty already exists for this period
        $existingPenalty = Penalty::where('invoice_id', $invoice->id)
            ->where('penalty_date', $asOfDate->toDateString())
            ->first();

        if ($existingPenalty) {
            return $existingPenalty; // Penalty already calculated for today
        }

        return DB::transaction(function () use ($invoice, $asOfDate, $daysOverdueWithGrace) {
            // Get penalty rate from config (percentage per month)
            $penaltyRatePerMonth = config('pms.business.late_penalty_rate', 2.0);

            // Calculate penalty
            $balance = $invoice->balance;
            $penaltyAmount = $this->calculatePenaltyAmount($balance, $penaltyRatePerMonth, $daysOverdueWithGrace);

            // Create penalty record
            $penalty = Penalty::create([
                'invoice_id' => $invoice->id,
                'penalty_date' => $asOfDate,
                'days_overdue' => $daysOverdueWithGrace,
                'penalty_rate' => $penaltyRatePerMonth,
                'base_amount' => $balance,
                'penalty_amount' => $penaltyAmount,
                'is_waived' => false,
            ]);

            return $penalty;
        });
    }

    /**
     * Calculate penalty amount based on rate and days
     */
    protected function calculatePenaltyAmount(float $balance, float $monthlyRate, int $daysOverdue): float
    {
        // Convert monthly rate to daily rate
        $daysInMonth = 30; // Use 30 days for consistent calculation
        $dailyRate = $monthlyRate / $daysInMonth / 100;

        // Calculate penalty
        $penaltyAmount = $balance * $dailyRate * $daysOverdue;

        return round($penaltyAmount, 2);
    }

    /**
     * Get all overdue invoices
     */
    protected function getOverdueInvoices(Carbon $asOfDate): Collection
    {
        return Invoice::where('due_date', '<', $asOfDate)
            ->whereColumn('amount_paid', '<', 'total_amount')
            ->whereIn('status', ['sent', 'partially_paid', 'overdue'])
            ->get();
    }

    /**
     * Waive penalty
     */
    public function waivePenalty(Penalty $penalty, int $waivedBy, string $reason): Penalty
    {
        $penalty->update([
            'is_waived' => true,
            'waived_by' => $waivedBy,
            'waived_at' => now(),
            'waiver_reason' => $reason,
        ]);

        return $penalty->fresh();
    }

    /**
     * Calculate total penalties for an invoice
     */
    public function getInvoiceTotalPenalties(Invoice $invoice, bool $includeWaived = false): float
    {
        $query = $invoice->penalties();

        if (!$includeWaived) {
            $query->where('is_waived', false);
        }

        return (float) $query->sum('penalty_amount');
    }

    /**
     * Get penalty summary for a tenant
     */
    public function getTenantPenaltySummary(int $tenantId): array
    {
        $invoices = Invoice::where('tenant_id', $tenantId)->get();

        $totalPenalties = 0;
        $activePenalties = 0;
        $waivedPenalties = 0;
        $penaltyCount = 0;

        foreach ($invoices as $invoice) {
            $penalties = $invoice->penalties;

            $penaltyCount += $penalties->count();
            $totalPenalties += $penalties->sum('penalty_amount');
            $activePenalties += $penalties->where('is_waived', false)->sum('penalty_amount');
            $waivedPenalties += $penalties->where('is_waived', true)->sum('penalty_amount');
        }

        return [
            'total_penalties' => $totalPenalties,
            'active_penalties' => $activePenalties,
            'waived_penalties' => $waivedPenalties,
            'penalty_count' => $penaltyCount,
        ];
    }

    /**
     * Calculate bounced check penalty
     */
    public function calculateBouncedCheckPenalty(float $checkAmount): float
    {
        $penaltyAmount = config('pms.business.bounced_check_penalty', 500.00);

        return (float) $penaltyAmount;
    }
}
