<?php

namespace App\Jobs;

use App\Models\LeaseContract;
use App\Services\BillingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ApplyRentEscalationJob implements ShouldQueue
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
        Log::info('Starting rent escalation job');

        $escalationsApplied = 0;
        $errors = 0;

        // Get lease contracts that need escalation
        $contractsNeedingEscalation = LeaseContract::needingEscalation()
            ->with(['units'])
            ->get();

        Log::info("Found {$contractsNeedingEscalation->count()} contracts needing escalation");

        foreach ($contractsNeedingEscalation as $contract) {
            try {
                // Store old rent values for logging
                $oldRent = $contract->total_monthly_rent;

                // Apply rent escalation
                $billingService->applyRentEscalation($contract);

                // Reload contract to get updated values
                $contract->refresh();
                $newRent = $contract->total_monthly_rent;

                Log::info("Applied rent escalation to contract {$contract->contract_number}: " .
                          "Old rent: {$oldRent}, New rent: {$newRent}, " .
                          "Escalation rate: {$contract->escalation_rate}%, " .
                          "Next escalation date: {$contract->next_escalation_date->toDateString()}");

                $escalationsApplied++;

            } catch (\Exception $e) {
                Log::error("Failed to apply rent escalation for contract {$contract->contract_number}: {$e->getMessage()}", [
                    'contract_id' => $contract->id,
                    'exception' => $e,
                ]);
                $errors++;
            }
        }

        Log::info("Rent escalation job completed. Escalations applied: {$escalationsApplied}, Errors: {$errors}");
    }
}
