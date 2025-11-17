<?php

namespace App\Jobs;

use App\Models\LeaseContract;
use App\Services\BillingService;
use App\Enums\BillingCycle;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyInvoicesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(BillingService $billingService): void
    {
        Log::info('Starting monthly invoice generation job');

        $currentDate = now();
        $invoicesGenerated = 0;
        $errors = 0;

        // Get all active lease contracts
        $activeContracts = LeaseContract::active()
            ->with(['units', 'tenant', 'property'])
            ->get();

        Log::info("Found {$activeContracts->count()} active lease contracts");

        foreach ($activeContracts as $contract) {
            try {
                // Check if invoice should be generated based on billing cycle
                if (!$this->shouldGenerateInvoice($contract, $currentDate)) {
                    Log::debug("Skipping contract {$contract->contract_number} - not due for billing");
                    continue;
                }

                // Calculate period start and end dates based on billing cycle
                [$periodStart, $periodEnd] = $this->calculateBillingPeriod($contract, $currentDate);

                // Check if invoice already exists for this period
                if ($this->invoiceExistsForPeriod($contract, $periodStart, $periodEnd)) {
                    Log::debug("Invoice already exists for contract {$contract->contract_number} for period {$periodStart->toDateString()} to {$periodEnd->toDateString()}");
                    continue;
                }

                // Generate the invoice
                $invoice = $billingService->generateInvoice($contract, $periodStart, $periodEnd);

                Log::info("Generated invoice {$invoice->invoice_number} for contract {$contract->contract_number}");
                $invoicesGenerated++;

            } catch (\Exception $e) {
                Log::error("Failed to generate invoice for contract {$contract->contract_number}: {$e->getMessage()}", [
                    'contract_id' => $contract->id,
                    'exception' => $e,
                ]);
                $errors++;
            }
        }

        Log::info("Monthly invoice generation job completed. Generated: {$invoicesGenerated}, Errors: {$errors}");
    }

    /**
     * Determine if invoice should be generated based on billing cycle
     */
    protected function shouldGenerateInvoice(LeaseContract $contract, Carbon $currentDate): bool
    {
        $billingDay = $contract->billing_day ?? 1;

        // Check if today is the billing day
        if ($currentDate->day !== $billingDay) {
            return false;
        }

        // Check billing cycle
        $billingCycle = $contract->billing_cycle;

        return match($billingCycle) {
            BillingCycle::MONTHLY => true,
            BillingCycle::QUARTERLY => $currentDate->month % 3 === 1,
            BillingCycle::SEMI_ANNUAL => in_array($currentDate->month, [1, 7]),
            BillingCycle::ANNUAL => $currentDate->month === 1,
            default => false,
        };
    }

    /**
     * Calculate billing period start and end dates
     */
    protected function calculateBillingPeriod(LeaseContract $contract, Carbon $currentDate): array
    {
        $billingCycle = $contract->billing_cycle;
        $months = $billingCycle->months();

        $periodStart = $currentDate->copy()->startOfMonth();
        $periodEnd = $currentDate->copy()->addMonths($months)->subDay()->endOfDay();

        return [$periodStart, $periodEnd];
    }

    /**
     * Check if invoice already exists for this period
     */
    protected function invoiceExistsForPeriod(LeaseContract $contract, Carbon $periodStart, Carbon $periodEnd): bool
    {
        return $contract->invoices()
            ->where('period_start', $periodStart->toDateString())
            ->where('period_end', $periodEnd->toDateString())
            ->exists();
    }
}
