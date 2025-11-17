<?php

namespace App\Console\Commands;

use App\Services\LegacyMigrationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class MigrateLegacyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pms:migrate-legacy-data
                            {--table= : Migrate specific table only}
                            {--dry-run : Show what would be migrated without actually migrating}
                            {--force : Skip confirmation prompts}
                            {--clean : Truncate new tables before migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from legacy PHP4 database to new Laravel 11 schema';

    protected LegacyMigrationService $migrationService;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('===========================================');
        $this->info('  PMS Legacy Data Migration Tool');
        $this->info('===========================================');
        $this->newLine();

        // Verify database connections
        if (!$this->verifyConnections()) {
            return Command::FAILURE;
        }

        // Show migration plan
        $this->showMigrationPlan();

        // Confirm before proceeding
        if (!$this->option('force') && !$this->option('dry-run')) {
            if (!$this->confirm('Do you want to proceed with the migration?', false)) {
                $this->info('Migration cancelled.');
                return Command::SUCCESS;
            }
        }

        // Clean tables if requested
        if ($this->option('clean') && !$this->option('dry-run')) {
            if (!$this->option('force')) {
                if (!$this->confirm('This will DELETE all existing data. Are you absolutely sure?', false)) {
                    $this->info('Migration cancelled.');
                    return Command::SUCCESS;
                }
            }
            $this->cleanTables();
        }

        // Dry run mode
        if ($this->option('dry-run')) {
            $this->warn('DRY RUN MODE - No data will be migrated');
            $this->showDryRunReport();
            return Command::SUCCESS;
        }

        // Initialize migration service
        $this->migrationService = app(LegacyMigrationService::class);

        // Run migration
        try {
            $startTime = microtime(true);

            if ($table = $this->option('table')) {
                $this->migrateSpecificTable($table);
            } else {
                $this->migrateAll();
            }

            $endTime = microtime(true);
            $duration = round($endTime - $startTime, 2);

            $this->newLine();
            $this->info("✓ Migration completed in {$duration} seconds");

            // Generate and display report
            $this->displayReport();

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('Migration failed: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }

    /**
     * Verify database connections
     */
    protected function verifyConnections(): bool
    {
        $this->info('Verifying database connections...');

        // Test new database connection
        try {
            DB::connection()->getPdo();
            $this->line('✓ New database connection: OK');
        } catch (Exception $e) {
            $this->error('✗ Cannot connect to new database: ' . $e->getMessage());
            return false;
        }

        // Test legacy database connection
        try {
            DB::connection('legacy')->getPdo();
            $this->line('✓ Legacy database connection: OK');
        } catch (Exception $e) {
            $this->error('✗ Cannot connect to legacy database: ' . $e->getMessage());
            $this->error('Please configure LEGACY_DB_* environment variables');
            return false;
        }

        $this->newLine();
        return true;
    }

    /**
     * Show migration plan
     */
    protected function showMigrationPlan(): void
    {
        $this->info('Migration Plan:');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        $tables = $this->getMigrationTables();

        $this->table(
            ['#', 'Table', 'Legacy Table', 'Est. Records'],
            $tables
        );

        $this->newLine();

        if ($this->option('table')) {
            $this->warn("Note: Only migrating table: " . $this->option('table'));
            $this->newLine();
        }
    }

    /**
     * Get migration tables information
     */
    protected function getMigrationTables(): array
    {
        $mapping = config('legacy.table_mapping');
        $tables = [];
        $index = 1;

        foreach ($mapping as $newTable => $legacyTable) {
            // Skip if specific table is requested and this isn't it
            if ($this->option('table') && $newTable !== $this->option('table')) {
                continue;
            }

            try {
                $count = DB::connection('legacy')->table($legacyTable)->count();
            } catch (Exception $e) {
                $count = 'N/A';
            }

            $tables[] = [
                $index++,
                $newTable,
                $legacyTable,
                is_numeric($count) ? number_format($count) : $count,
            ];
        }

        return $tables;
    }

    /**
     * Clean tables before migration
     */
    protected function cleanTables(): void
    {
        $this->warn('Cleaning existing data...');

        $tables = [
            'payment_applications',
            'payments',
            'invoice_line_items',
            'invoices',
            'contract_charges',
            'lease_contract_unit',
            'lease_contracts',
            'lease_applications',
            'reservations',
            'inquiries',
            'work_orders',
            'maintenance_requests',
            'tenants',
            'companies',
            'units',
            'floors',
            'buildings',
            'properties',
        ];

        $bar = $this->output->createProgressBar(count($tables));
        $bar->start();

        foreach ($tables as $table) {
            try {
                DB::table($table)->truncate();
                $bar->advance();
            } catch (Exception $e) {
                // Table might not exist, continue
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info('✓ Tables cleaned');
        $this->newLine();
    }

    /**
     * Show dry run report
     */
    protected function showDryRunReport(): void
    {
        $this->newLine();
        $this->info('Dry Run Report:');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        $mapping = config('legacy.table_mapping');

        foreach ($mapping as $newTable => $legacyTable) {
            if ($this->option('table') && $newTable !== $this->option('table')) {
                continue;
            }

            try {
                $count = DB::connection('legacy')->table($legacyTable)->count();
                $this->line("Would migrate {$count} records from '{$legacyTable}' to '{$newTable}'");
            } catch (Exception $e) {
                $this->warn("Cannot access table '{$legacyTable}': " . $e->getMessage());
            }
        }

        $this->newLine();
    }

    /**
     * Migrate all tables
     */
    protected function migrateAll(): void
    {
        $this->info('Starting full migration...');
        $this->newLine();

        $steps = [
            'Properties' => 'migrateProperties',
            'Buildings' => 'migrateBuildings',
            'Floors' => 'migrateFloors',
            'Units' => 'migrateUnits',
            'Companies' => 'migrateCompanies',
            'Tenants' => 'migrateTenants',
            'Inquiries' => 'migrateInquiries',
            'Reservations' => 'migrateReservations',
            'Lease Applications' => 'migrateLeaseApplications',
            'Lease Contracts' => 'migrateLeaseContracts',
            'Invoices' => 'migrateInvoices',
            'Payments' => 'migratePayments',
            'Maintenance Requests' => 'migrateMaintenanceRequests',
            'Work Orders' => 'migrateWorkOrders',
            'Data Cleanup' => 'cleanupData',
        ];

        $totalSteps = count($steps);
        $currentStep = 1;

        foreach ($steps as $stepName => $method) {
            $this->info("[{$currentStep}/{$totalSteps}] Migrating {$stepName}...");

            $bar = $this->output->createProgressBar();
            $bar->start();

            $this->migrationService->$method();

            $bar->finish();
            $this->newLine();

            $stats = $this->migrationService->getStats();
            $tableName = $this->getTableNameFromMethod($method);

            if (isset($stats[$tableName])) {
                $this->displayStepStats($stats[$tableName]);
            }

            $this->newLine();
            $currentStep++;
        }
    }

    /**
     * Migrate specific table
     */
    protected function migrateSpecificTable(string $table): void
    {
        $this->info("Migrating table: {$table}");
        $this->newLine();

        $methodMap = [
            'properties' => 'migrateProperties',
            'buildings' => 'migrateBuildings',
            'floors' => 'migrateFloors',
            'units' => 'migrateUnits',
            'companies' => 'migrateCompanies',
            'tenants' => 'migrateTenants',
            'inquiries' => 'migrateInquiries',
            'reservations' => 'migrateReservations',
            'lease_applications' => 'migrateLeaseApplications',
            'lease_contracts' => 'migrateLeaseContracts',
            'invoices' => 'migrateInvoices',
            'payments' => 'migratePayments',
            'maintenance_requests' => 'migrateMaintenanceRequests',
            'work_orders' => 'migrateWorkOrders',
        ];

        if (!isset($methodMap[$table])) {
            $this->error("Unknown table: {$table}");
            $this->info('Available tables: ' . implode(', ', array_keys($methodMap)));
            return;
        }

        $method = $methodMap[$table];
        $bar = $this->output->createProgressBar();
        $bar->start();

        $this->migrationService->$method();

        $bar->finish();
        $this->newLine();

        $stats = $this->migrationService->getStats();
        if (isset($stats[$table])) {
            $this->displayStepStats($stats[$table]);
        }
    }

    /**
     * Display step statistics
     */
    protected function displayStepStats(array $stats): void
    {
        $this->line("  Total: {$stats['total']} | Success: {$stats['success']} | Failed: {$stats['failed']} | Skipped: {$stats['skipped']}");
    }

    /**
     * Display final migration report
     */
    protected function displayReport(): void
    {
        $report = $this->migrationService->generateReport();

        $this->newLine();
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('  Migration Report');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();

        // Summary
        $this->info('Summary:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Records', number_format($report['summary']['total_records'])],
                ['Successfully Migrated', number_format($report['summary']['total_success'])],
                ['Failed', number_format($report['summary']['total_failed'])],
                ['Skipped', number_format($report['summary']['total_skipped'])],
            ]
        );

        $this->newLine();

        // Detailed breakdown
        $this->info('Detailed Breakdown:');
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

        $this->table(
            ['Table', 'Total', 'Success', 'Failed', 'Skipped', 'Success Rate'],
            $tableData
        );

        // Errors
        if (count($report['errors']) > 0) {
            $this->newLine();
            $this->warn('Errors occurred during migration:');
            $this->warn('Total errors: ' . count($report['errors']));
            $this->line('Check ' . config('legacy.log_file') . ' for details');

            // Show first 10 errors
            $errorSample = array_slice($report['errors'], 0, 10);
            $errorData = [];

            foreach ($errorSample as $error) {
                $errorData[] = [
                    $error['table'],
                    $error['legacy_id'],
                    substr($error['message'], 0, 50) . '...',
                ];
            }

            $this->table(
                ['Table', 'Legacy ID', 'Error'],
                $errorData
            );

            if (count($report['errors']) > 10) {
                $this->line('... and ' . (count($report['errors']) - 10) . ' more errors');
            }
        }

        $this->newLine();

        // Log file location
        $this->info('Full migration log: ' . config('legacy.log_file'));
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
