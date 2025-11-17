<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\GenerateMonthlyInvoicesJob;
use App\Jobs\CalculateLatePenaltiesJob;
use App\Jobs\ApplyRentEscalationJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Generate monthly invoices on 1st of each month at 1:00 AM
        $schedule->job(new GenerateMonthlyInvoicesJob)
            ->monthlyOn(1, '01:00')
            ->name('generate-monthly-invoices')
            ->withoutOverlapping()
            ->onOneServer();

        // Calculate late penalties daily at 2:00 AM
        $schedule->job(new CalculateLatePenaltiesJob)
            ->dailyAt('02:00')
            ->name('calculate-late-penalties')
            ->withoutOverlapping()
            ->onOneServer();

        // Check for rent escalations daily at 3:00 AM
        $schedule->job(new ApplyRentEscalationJob)
            ->dailyAt('03:00')
            ->name('apply-rent-escalation')
            ->withoutOverlapping()
            ->onOneServer();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
