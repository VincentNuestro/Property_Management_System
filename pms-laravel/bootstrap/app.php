<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        // Generate monthly invoices on 1st of each month at 1:00 AM
        $schedule->job(new \App\Jobs\GenerateMonthlyInvoicesJob)
            ->monthlyOn(1, '01:00')
            ->name('generate-monthly-invoices')
            ->withoutOverlapping()
            ->onOneServer();

        // Calculate late penalties daily at 2:00 AM
        $schedule->job(new \App\Jobs\CalculateLatePenaltiesJob)
            ->dailyAt('02:00')
            ->name('calculate-late-penalties')
            ->withoutOverlapping()
            ->onOneServer();

        // Check for rent escalations daily at 3:00 AM
        $schedule->job(new \App\Jobs\ApplyRentEscalationJob)
            ->dailyAt('03:00')
            ->name('apply-rent-escalation')
            ->withoutOverlapping()
            ->onOneServer();
    })
    ->create();
