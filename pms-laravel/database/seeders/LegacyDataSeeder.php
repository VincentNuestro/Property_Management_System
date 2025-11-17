<?php

namespace Database\Seeders;

use App\Services\LegacyMigrationService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

class LegacyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This seeder uses the LegacyMigrationService to migrate data
     * from the legacy PHP4 database to the new Laravel 11 schema.
     *
     * Usage:
     *   php artisan db:seed --class=LegacyDataSeeder
     */
    public function run(): void
    {
        $this->command->info('Starting legacy data migration via seeder...');
        $this->command->newLine();

        // Verify legacy database connection
        try {
            DB::connection('legacy')->getPdo();
            $this->command->line('✓ Legacy database connection verified');
        } catch (Exception $e) {
            $this->command->error('✗ Cannot connect to legacy database');
            $this->command->error('Error: ' . $e->getMessage());
            $this->command->error('Please configure LEGACY_DB_* environment variables');
            return;
        }

        $this->command->newLine();

        // Confirm before proceeding
        if (!$this->command->confirm('This will migrate data from the legacy database. Continue?', false)) {
            $this->command->info('Migration cancelled.');
            return;
        }

        $this->command->newLine();

        // Initialize migration service
        $migrationService = app(LegacyMigrationService::class);

        try {
            $startTime = microtime(true);

            // Run all migrations
            $this->command->info('Running migrations...');
            $this->command->newLine();

            $this->migrateWithProgress($migrationService, 'Properties', 'migrateProperties');
            $this->migrateWithProgress($migrationService, 'Buildings', 'migrateBuildings');
            $this->migrateWithProgress($migrationService, 'Floors', 'migrateFloors');
            $this->migrateWithProgress($migrationService, 'Units', 'migrateUnits');
            $this->migrateWithProgress($migrationService, 'Companies', 'migrateCompanies');
            $this->migrateWithProgress($migrationService, 'Tenants', 'migrateTenants');
            $this->migrateWithProgress($migrationService, 'Inquiries', 'migrateInquiries');
            $this->migrateWithProgress($migrationService, 'Reservations', 'migrateReservations');
            $this->migrateWithProgress($migrationService, 'Lease Applications', 'migrateLeaseApplications');
            $this->migrateWithProgress($migrationService, 'Lease Contracts', 'migrateLeaseContracts');
            $this->migrateWithProgress($migrationService, 'Invoices', 'migrateInvoices');
            $this->migrateWithProgress($migrationService, 'Payments', 'migratePayments');
            $this->migrateWithProgress($migrationService, 'Maintenance Requests', 'migrateMaintenanceRequests');
            $this->migrateWithProgress($migrationService, 'Work Orders', 'migrateWorkOrders');

            $this->command->info('Running data cleanup...');
            $migrationService->cleanupData();
            $this->command->line('✓ Data cleanup completed');
            $this->command->newLine();

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            // Display report
            $this->displayReport($migrationService, $duration);

        } catch (Exception $e) {
            $this->command->error('Migration failed: ' . $e->getMessage());
            $this->command->error($e->getTraceAsString());
        }
    }

    /**
     * Migrate with progress indicator
     */
    protected function migrateWithProgress(LegacyMigrationService $service, string $label, string $method): void
    {
        $this->command->info("Migrating {$label}...");

        $bar = $this->command->getOutput()->createProgressBar();
        $bar->start();

        $service->$method();

        $bar->finish();
        $this->command->newLine();

        $stats = $service->getStats();
        $tableName = $this->getTableNameFromMethod($method);

        if (isset($stats[$tableName])) {
            $this->displayStepStats($stats[$tableName]);
        }

        $this->command->newLine();
    }

    /**
     * Display step statistics
     */
    protected function displayStepStats(array $stats): void
    {
        $this->command->line(
            "  Total: {$stats['total']} | " .
            "Success: {$stats['success']} | " .
            "Failed: {$stats['failed']} | " .
            "Skipped: {$stats['skipped']}"
        );
    }

    /**
     * Display final migration report
     */
    protected function displayReport(LegacyMigrationService $service, float $duration): void
    {
        $report = $service->generateReport();

        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('  Migration Report');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();

        $this->command->info("Duration: {$duration} seconds");
        $this->command->newLine();

        // Summary
        $this->command->table(
            ['Metric', 'Count'],
            [
                ['Total Records', number_format($report['summary']['total_records'])],
                ['Successfully Migrated', number_format($report['summary']['total_success'])],
                ['Failed', number_format($report['summary']['total_failed'])],
                ['Skipped', number_format($report['summary']['total_skipped'])],
            ]
        );

        $this->command->newLine();

        // Detailed breakdown
        $this->command->info('Detailed Breakdown:');
        $tableData = [];

        foreach ($report['details'] as $table => $stats) {
            if ($stats['total'] > 0) {
                $successRate = $stats['total'] > 0 ? round(($stats['success'] / $stats['total']) * 100, 1) : 0;
                $tableData[] = [
                    ucwords(str_replace('_', ' ', $table)),
                    number_format($stats['total']),
                    number_format($stats['success']),
                    number_format($stats['failed']),
                    number_format($stats['skipped']),
                    $successRate . '%',
                ];
            }
        }

        $this->command->table(
            ['Table', 'Total', 'Success', 'Failed', 'Skipped', 'Success Rate'],
            $tableData
        );

        // Errors
        if (count($report['errors']) > 0) {
            $this->command->newLine();
            $this->command->warn('Errors occurred during migration:');
            $this->command->warn('Total errors: ' . count($report['errors']));
            $this->command->line('Check ' . config('legacy.log_file') . ' for details');

            // Show first 5 errors
            $errorSample = array_slice($report['errors'], 0, 5);
            $errorData = [];

            foreach ($errorSample as $error) {
                $errorData[] = [
                    $error['table'],
                    $error['legacy_id'],
                    substr($error['message'], 0, 60) . '...',
                ];
            }

            $this->command->table(
                ['Table', 'Legacy ID', 'Error'],
                $errorData
            );

            if (count($report['errors']) > 5) {
                $this->command->line('... and ' . (count($report['errors']) - 5) . ' more errors');
            }
        }

        $this->command->newLine();
        $this->command->info('✓ Migration completed successfully');
        $this->command->info('Log file: ' . config('legacy.log_file'));
    }

    /**
     * Get table name from method name
     */
    protected function getTableNameFromMethod(string $method): string
    {
        $methodToTable = [
            'migrateProperties' => 'properties',
            'migrateBuildings' => 'buildings',
            'migrateFloors' => 'floors',
            'migrateUnits' => 'units',
            'migrateCompanies' => 'companies',
            'migrateTenants' => 'tenants',
            'migrateInquiries' => 'inquiries',
            'migrateReservations' => 'reservations',
            'migrateLeaseApplications' => 'lease_applications',
            'migrateLeaseContracts' => 'lease_contracts',
            'migrateInvoices' => 'invoices',
            'migratePayments' => 'payments',
            'migrateMaintenanceRequests' => 'maintenance_requests',
            'migrateWorkOrders' => 'work_orders',
        ];

        return $methodToTable[$method] ?? 'unknown';
    }
}
