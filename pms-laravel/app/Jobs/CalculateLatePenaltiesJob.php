<?php

namespace App\Jobs;

use App\Services\PenaltyCalculationService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CalculateLatePenaltiesJob implements ShouldQueue
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
    public function handle(PenaltyCalculationService $penaltyService): void
    {
        Log::info('Starting late penalties calculation job');

        $currentDate = now();
        $penaltiesCreated = 0;
        $errors = 0;

        try {
            // Calculate penalties for all overdue invoices
            $penalties = $penaltyService->calculatePenalties($currentDate);

            $penaltiesCreated = $penalties->count();

            // Log details of created penalties
            foreach ($penalties as $penalty) {
                Log::info("Created penalty for invoice {$penalty->invoice->invoice_number}: " .
                          "Amount: {$penalty->penalty_amount}, Days overdue: {$penalty->days_overdue}");
            }

            Log::info("Late penalties calculation job completed. Penalties created: {$penaltiesCreated}");

        } catch (\Exception $e) {
            Log::error("Failed to calculate late penalties: {$e->getMessage()}", [
                'exception' => $e,
            ]);
            $errors++;
            throw $e;
        }
    }
}
