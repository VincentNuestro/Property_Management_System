<?php

namespace App\Services;

use App\DataMigration\Mappers\PropertyMapper;
use App\DataMigration\Mappers\UnitMapper;
use App\DataMigration\Mappers\TenantMapper;
use App\DataMigration\Mappers\LeaseContractMapper;
use App\DataMigration\Mappers\InvoiceMapper;
use App\DataMigration\Mappers\PaymentMapper;
use App\Models\Property;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Unit;
use App\Models\Company;
use App\Models\Tenant;
use App\Models\Inquiry;
use App\Models\Reservation;
use App\Models\LeaseApplication;
use App\Models\LeaseContract;
use App\Models\Invoice;
use App\Models\InvoiceLineItem;
use App\Models\Payment;
use App\Models\PaymentApplication;
use App\Models\MaintenanceRequest;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class LegacyMigrationService
{
    protected array $stats = [];
    protected array $errors = [];
    protected PropertyMapper $propertyMapper;
    protected UnitMapper $unitMapper;
    protected TenantMapper $tenantMapper;
    protected LeaseContractMapper $leaseContractMapper;
    protected InvoiceMapper $invoiceMapper;
    protected PaymentMapper $paymentMapper;

    public function __construct()
    {
        $this->propertyMapper = new PropertyMapper();
        $this->unitMapper = new UnitMapper();
        $this->tenantMapper = new TenantMapper();
        $this->leaseContractMapper = new LeaseContractMapper();
        $this->invoiceMapper = new InvoiceMapper();
        $this->paymentMapper = new PaymentMapper();

        $this->initializeStats();
    }

    protected function initializeStats(): void
    {
        $tables = [
            'properties', 'buildings', 'floors', 'units', 'companies', 'tenants',
            'inquiries', 'reservations', 'lease_applications', 'lease_contracts',
            'invoices', 'invoice_line_items', 'payments', 'payment_applications',
            'maintenance_requests', 'work_orders'
        ];

        foreach ($tables as $table) {
            $this->stats[$table] = [
                'total' => 0,
                'success' => 0,
                'failed' => 0,
                'skipped' => 0,
            ];
        }
    }

    /**
     * Run all migrations in sequence
     */
    public function migrateAll(): array
    {
        $this->log('Starting full migration process...');

        try {
            // Core entities
            $this->migrateProperties();
            $this->migrateBuildings();
            $this->migrateFloors();
            $this->migrateUnits();

            // Business entities
            $this->migrateCompanies();
            $this->migrateTenants();

            // Leasing workflow
            $this->migrateInquiries();
            $this->migrateReservations();
            $this->migrateLeaseApplications();
            $this->migrateLeaseContracts();

            // Financial
            $this->migrateInvoices();
            $this->migratePayments();

            // Operations
            $this->migrateMaintenanceRequests();
            $this->migrateWorkOrders();

            // Final cleanup
            $this->cleanupData();

            $this->log('Migration process completed successfully');
        } catch (Exception $e) {
            $this->log('Migration failed: ' . $e->getMessage(), 'error');
            throw $e;
        }

        return $this->generateReport();
    }

    /**
     * Migrate property data
     */
    public function migrateProperties(): void
    {
        $this->log('Migrating properties...');
        $tableName = 'properties';

        $legacyTable = config('legacy.table_mapping.properties');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $data = $this->propertyMapper->map((array) $record);

                            if ($this->propertyMapper->validate($data)) {
                                Property::create($data);
                                $this->stats[$tableName]['success']++;
                            } else {
                                $this->stats[$tableName]['skipped']++;
                                $this->logError($tableName, $record->id ?? 'unknown', 'Validation failed');
                            }
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Properties migration completed: {$this->stats[$tableName]['success']} success, {$this->stats[$tableName]['failed']} failed");
    }

    /**
     * Migrate building data
     */
    public function migrateBuildings(): void
    {
        $this->log('Migrating buildings...');
        $tableName = 'buildings';

        $legacyTable = config('legacy.table_mapping.buildings');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $propertyId = $this->findNewPropertyId($record->PropertyID ?? $record->MallID ?? null);

                            if (!$propertyId) {
                                $this->stats[$tableName]['skipped']++;
                                continue;
                            }

                            $data = [
                                'property_id' => $propertyId,
                                'code' => $this->cleanString($record->BuildingCode ?? $record->BldgCode ?? ''),
                                'name' => $this->cleanString($record->BuildingName ?? $record->BldgName ?? ''),
                                'total_floors' => $record->TotalFloors ?? $record->NoOfFloors ?? 0,
                                'status' => $this->mapStatus($record->Status ?? 'active'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];

                            Building::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Buildings migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate floor data
     */
    public function migrateFloors(): void
    {
        $this->log('Migrating floors...');
        $tableName = 'floors';

        $legacyTable = config('legacy.table_mapping.floors');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $buildingId = $this->findNewBuildingId($record->BuildingID ?? $record->BldgID ?? null);

                            if (!$buildingId) {
                                $this->stats[$tableName]['skipped']++;
                                continue;
                            }

                            $data = [
                                'building_id' => $buildingId,
                                'floor_number' => $record->FloorNumber ?? $record->FloorLevel ?? 0,
                                'floor_name' => $this->cleanString($record->FloorName ?? ''),
                                'display_name' => $this->cleanString($record->DisplayName ?? $record->FloorName ?? ''),
                                'total_units' => $record->TotalUnits ?? 0,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];

                            Floor::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Floors migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate unit data
     */
    public function migrateUnits(): void
    {
        $this->log('Migrating units...');
        $tableName = 'units';

        $legacyTable = config('legacy.table_mapping.units');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $data = $this->unitMapper->map((array) $record);

                            if ($this->unitMapper->validate($data)) {
                                Unit::create($data);
                                $this->stats[$tableName]['success']++;
                            } else {
                                $this->stats[$tableName]['skipped']++;
                                $this->logError($tableName, $record->id ?? 'unknown', 'Validation failed');
                            }
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Units migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate company data
     */
    public function migrateCompanies(): void
    {
        $this->log('Migrating companies...');
        $tableName = 'companies';

        $legacyTable = config('legacy.table_mapping.companies');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $data = [
                                'name' => $this->cleanString($record->CompanyName ?? $record->Name ?? ''),
                                'trade_name' => $this->cleanString($record->TradeName ?? $record->CompanyName ?? ''),
                                'business_type' => $this->cleanString($record->BusinessType ?? null),
                                'industry' => $this->cleanString($record->Industry ?? null),
                                'tax_id' => $this->cleanString($record->TIN ?? $record->TaxID ?? null),
                                'email' => $this->cleanEmail($record->Email ?? $record->ContactEmail ?? null),
                                'phone' => $this->cleanString($record->Phone ?? $record->ContactNumber ?? null),
                                'website' => $this->cleanString($record->Website ?? null),
                                'address_line1' => $this->cleanString($record->Address ?? $record->Address1 ?? null),
                                'address_line2' => $this->cleanString($record->Address2 ?? null),
                                'city' => $this->cleanString($record->City ?? null),
                                'state' => $this->cleanString($record->Province ?? $record->State ?? null),
                                'postal_code' => $this->cleanString($record->ZipCode ?? $record->PostalCode ?? null),
                                'country' => $this->cleanString($record->Country ?? 'Philippines'),
                                'status' => $this->mapStatus($record->Status ?? 'active'),
                                'notes' => $this->cleanString($record->Notes ?? $record->Remarks ?? null),
                                'created_at' => $this->parseDate($record->DateCreated ?? null) ?? now(),
                                'updated_at' => now(),
                            ];

                            Company::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Companies migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate tenant data (Individual and Corporate)
     */
    public function migrateTenants(): void
    {
        $this->log('Migrating tenants...');
        $tableName = 'tenants';

        $legacyTable = config('legacy.table_mapping.tenants');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $data = $this->tenantMapper->map((array) $record);

                            if ($this->tenantMapper->validate($data)) {
                                Tenant::create($data);
                                $this->stats[$tableName]['success']++;
                            } else {
                                $this->stats[$tableName]['skipped']++;
                                $this->logError($tableName, $record->id ?? 'unknown', 'Validation failed');
                            }
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Tenants migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate inquiry data
     */
    public function migrateInquiries(): void
    {
        $this->log('Migrating inquiries...');
        $tableName = 'inquiries';

        $legacyTable = config('legacy.table_mapping.inquiries');

        if (!$this->tableExists('legacy', $legacyTable)) {
            $this->log("Table {$legacyTable} does not exist, skipping...");
            return;
        }

        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $propertyId = $this->findNewPropertyId($record->PropertyID ?? $record->MallID ?? null);
                            $tenantId = $this->findNewTenantId($record->TenantID ?? null);

                            $data = [
                                'property_id' => $propertyId,
                                'tenant_id' => $tenantId,
                                'inquiry_date' => $this->parseDate($record->InquiryDate ?? $record->DateInquired ?? null) ?? now(),
                                'source' => $this->cleanString($record->Source ?? 'walk-in'),
                                'preferred_unit_type' => $this->cleanString($record->PreferredUnitType ?? null),
                                'preferred_move_in_date' => $this->parseDate($record->PreferredMoveInDate ?? null),
                                'budget_range_min' => $record->BudgetMin ?? null,
                                'budget_range_max' => $record->BudgetMax ?? null,
                                'status' => $this->mapInquiryStatus($record->Status ?? 'new'),
                                'notes' => $this->cleanString($record->Notes ?? $record->Remarks ?? null),
                                'created_at' => $this->parseDate($record->DateCreated ?? null) ?? now(),
                                'updated_at' => now(),
                            ];

                            Inquiry::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Inquiries migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate reservation data
     */
    public function migrateReservations(): void
    {
        $this->log('Migrating reservations...');
        $tableName = 'reservations';

        $legacyTable = config('legacy.table_mapping.reservations');

        if (!$this->tableExists('legacy', $legacyTable)) {
            $this->log("Table {$legacyTable} does not exist, skipping...");
            return;
        }

        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $propertyId = $this->findNewPropertyId($record->PropertyID ?? $record->MallID ?? null);
                            $unitId = $this->findNewUnitId($record->UnitID ?? null);
                            $tenantId = $this->findNewTenantId($record->TenantID ?? null);

                            $data = [
                                'property_id' => $propertyId,
                                'unit_id' => $unitId,
                                'tenant_id' => $tenantId,
                                'reservation_date' => $this->parseDate($record->ReservationDate ?? $record->DateReserved ?? null) ?? now(),
                                'reservation_fee' => $record->ReservationFee ?? $record->Fee ?? 0,
                                'payment_date' => $this->parseDate($record->PaymentDate ?? null),
                                'valid_until' => $this->parseDate($record->ValidUntil ?? $record->ExpiryDate ?? null),
                                'status' => $this->mapReservationStatus($record->Status ?? 'pending'),
                                'notes' => $this->cleanString($record->Notes ?? $record->Remarks ?? null),
                                'created_at' => $this->parseDate($record->DateCreated ?? null) ?? now(),
                                'updated_at' => now(),
                            ];

                            Reservation::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Reservations migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate lease application data
     */
    public function migrateLeaseApplications(): void
    {
        $this->log('Migrating lease applications...');
        $tableName = 'lease_applications';

        $legacyTable = config('legacy.table_mapping.lease_applications');

        if (!$this->tableExists('legacy', $legacyTable)) {
            $this->log("Table {$legacyTable} does not exist, skipping...");
            return;
        }

        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $propertyId = $this->findNewPropertyId($record->PropertyID ?? $record->MallID ?? null);
                            $tenantId = $this->findNewTenantId($record->TenantID ?? null);

                            $data = [
                                'property_id' => $propertyId,
                                'tenant_id' => $tenantId,
                                'application_number' => $this->cleanString($record->ApplicationNo ?? $record->RefNo ?? ''),
                                'application_date' => $this->parseDate($record->ApplicationDate ?? $record->DateApplied ?? null) ?? now(),
                                'desired_move_in_date' => $this->parseDate($record->MoveInDate ?? $record->DesiredMoveInDate ?? null),
                                'monthly_budget' => $record->MonthlyBudget ?? $record->Budget ?? null,
                                'lease_term_months' => $record->LeaseTermMonths ?? $record->Term ?? null,
                                'status' => $this->mapLeaseApplicationStatus($record->Status ?? 'pending'),
                                'notes' => $this->cleanString($record->Notes ?? $record->Remarks ?? null),
                                'created_at' => $this->parseDate($record->DateCreated ?? null) ?? now(),
                                'updated_at' => now(),
                            ];

                            LeaseApplication::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Lease applications migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate lease contracts with units
     */
    public function migrateLeaseContracts(): void
    {
        $this->log('Migrating lease contracts...');
        $tableName = 'lease_contracts';

        $legacyTable = config('legacy.table_mapping.lease_contracts');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $data = $this->leaseContractMapper->map((array) $record);

                            if ($this->leaseContractMapper->validate($data)) {
                                $leaseContract = LeaseContract::create($data);

                                // Attach units if UnitID is present
                                if (isset($record->UnitID) && $record->UnitID) {
                                    $newUnitId = $this->findNewUnitId($record->UnitID);
                                    if ($newUnitId) {
                                        $leaseContract->units()->attach($newUnitId, [
                                            'monthly_rent' => $record->MonthlyRent ?? $record->Rent ?? 0,
                                            'association_dues' => $record->AssociationDues ?? $record->Dues ?? 0,
                                        ]);
                                    }
                                }

                                $this->stats[$tableName]['success']++;
                            } else {
                                $this->stats[$tableName]['skipped']++;
                                $this->logError($tableName, $record->id ?? 'unknown', 'Validation failed');
                            }
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Lease contracts migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate invoices and line items
     */
    public function migrateInvoices(): void
    {
        $this->log('Migrating invoices...');
        $tableName = 'invoices';

        $legacyTable = config('legacy.table_mapping.invoices');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $data = $this->invoiceMapper->map((array) $record);

                            if ($this->invoiceMapper->validate($data)) {
                                $invoice = Invoice::create($data);

                                // Migrate line items
                                $this->migrateInvoiceLineItems($record->id ?? null, $invoice->id);

                                $this->stats[$tableName]['success']++;
                            } else {
                                $this->stats[$tableName]['skipped']++;
                                $this->logError($tableName, $record->id ?? 'unknown', 'Validation failed');
                            }
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Invoices migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate invoice line items for a specific invoice
     */
    protected function migrateInvoiceLineItems(?int $legacyInvoiceId, int $newInvoiceId): void
    {
        if (!$legacyInvoiceId) {
            return;
        }

        $tableName = 'invoice_line_items';
        $legacyTable = config('legacy.table_mapping.invoice_line_items');

        $lineItems = DB::connection('legacy')
            ->table($legacyTable)
            ->where('SOAHeaderID', $legacyInvoiceId)
            ->orWhere('InvoiceID', $legacyInvoiceId)
            ->get();

        foreach ($lineItems as $item) {
            try {
                $data = [
                    'invoice_id' => $newInvoiceId,
                    'charge_type_id' => null, // Will need to map or create charge types
                    'description' => $this->cleanString($item->Description ?? $item->ChargeDesc ?? ''),
                    'quantity' => $item->Quantity ?? $item->Qty ?? 1,
                    'unit_price' => $item->UnitPrice ?? $item->Rate ?? $item->Amount ?? 0,
                    'subtotal' => $item->Subtotal ?? $item->Amount ?? 0,
                    'tax_amount' => $item->TaxAmount ?? $item->Tax ?? 0,
                    'total' => $item->Total ?? $item->Amount ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                InvoiceLineItem::create($data);
                $this->stats[$tableName]['success']++;
            } catch (Exception $e) {
                $this->stats[$tableName]['failed']++;
                $this->logError($tableName, $item->id ?? 'unknown', $e->getMessage());
            }
        }
    }

    /**
     * Migrate payments and allocations
     */
    public function migratePayments(): void
    {
        $this->log('Migrating payments...');
        $tableName = 'payments';

        $legacyTable = config('legacy.table_mapping.payments');
        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $data = $this->paymentMapper->map((array) $record);

                            if ($this->paymentMapper->validate($data)) {
                                $payment = Payment::create($data);

                                // Migrate payment applications/allocations
                                $this->migratePaymentApplications($record->id ?? null, $payment->id);

                                $this->stats[$tableName]['success']++;
                            } else {
                                $this->stats[$tableName]['skipped']++;
                                $this->logError($tableName, $record->id ?? 'unknown', 'Validation failed');
                            }
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Payments migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate payment applications for a specific payment
     */
    protected function migratePaymentApplications(?int $legacyPaymentId, int $newPaymentId): void
    {
        if (!$legacyPaymentId) {
            return;
        }

        $tableName = 'payment_applications';
        $legacyTable = config('legacy.table_mapping.payment_applications');

        if (!$this->tableExists('legacy', $legacyTable)) {
            return;
        }

        $applications = DB::connection('legacy')
            ->table($legacyTable)
            ->where('PaymentID', $legacyPaymentId)
            ->get();

        foreach ($applications as $app) {
            try {
                $newInvoiceId = $this->findNewInvoiceId($app->InvoiceID ?? $app->SOAHeaderID ?? null);

                if (!$newInvoiceId) {
                    continue;
                }

                $data = [
                    'payment_id' => $newPaymentId,
                    'invoice_id' => $newInvoiceId,
                    'amount_applied' => $app->AmountApplied ?? $app->Amount ?? 0,
                    'application_date' => $this->parseDate($app->ApplicationDate ?? null) ?? now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                PaymentApplication::create($data);
                $this->stats[$tableName]['success']++;
            } catch (Exception $e) {
                $this->stats[$tableName]['failed']++;
                $this->logError($tableName, $app->id ?? 'unknown', $e->getMessage());
            }
        }
    }

    /**
     * Migrate maintenance requests
     */
    public function migrateMaintenanceRequests(): void
    {
        $this->log('Migrating maintenance requests...');
        $tableName = 'maintenance_requests';

        $legacyTable = config('legacy.table_mapping.maintenance_requests');

        if (!$this->tableExists('legacy', $legacyTable)) {
            $this->log("Table {$legacyTable} does not exist, skipping...");
            return;
        }

        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $propertyId = $this->findNewPropertyId($record->PropertyID ?? $record->MallID ?? null);
                            $unitId = $this->findNewUnitId($record->UnitID ?? null);
                            $tenantId = $this->findNewTenantId($record->TenantID ?? null);

                            $data = [
                                'property_id' => $propertyId,
                                'unit_id' => $unitId,
                                'tenant_id' => $tenantId,
                                'request_number' => $this->cleanString($record->RequestNo ?? $record->ComplaintNo ?? ''),
                                'request_date' => $this->parseDate($record->RequestDate ?? $record->DateReported ?? null) ?? now(),
                                'category' => $this->cleanString($record->Category ?? $record->Type ?? 'general'),
                                'priority' => $this->mapPriority($record->Priority ?? 'medium'),
                                'subject' => $this->cleanString($record->Subject ?? $record->Title ?? ''),
                                'description' => $this->cleanString($record->Description ?? $record->Details ?? ''),
                                'status' => $this->mapMaintenanceRequestStatus($record->Status ?? 'pending'),
                                'notes' => $this->cleanString($record->Notes ?? $record->Remarks ?? null),
                                'created_at' => $this->parseDate($record->DateCreated ?? null) ?? now(),
                                'updated_at' => now(),
                            ];

                            MaintenanceRequest::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Maintenance requests migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Migrate work orders
     */
    public function migrateWorkOrders(): void
    {
        $this->log('Migrating work orders...');
        $tableName = 'work_orders';

        $legacyTable = config('legacy.table_mapping.work_orders');

        if (!$this->tableExists('legacy', $legacyTable)) {
            $this->log("Table {$legacyTable} does not exist, skipping...");
            return;
        }

        $total = DB::connection('legacy')->table($legacyTable)->count();
        $this->stats[$tableName]['total'] = $total;

        DB::connection('legacy')->table($legacyTable)
            ->orderBy('id')
            ->chunk(config('legacy.chunk_size', 1000), function ($records) use ($tableName) {
                DB::transaction(function () use ($records, $tableName) {
                    foreach ($records as $record) {
                        try {
                            $propertyId = $this->findNewPropertyId($record->PropertyID ?? $record->MallID ?? null);
                            $maintenanceRequestId = null; // Map from ComplaintID if exists

                            $data = [
                                'property_id' => $propertyId,
                                'maintenance_request_id' => $maintenanceRequestId,
                                'work_order_number' => $this->cleanString($record->WorkOrderNo ?? $record->WONumber ?? ''),
                                'type' => $this->mapWorkOrderType($record->Type ?? 'corrective'),
                                'priority' => $this->mapPriority($record->Priority ?? 'medium'),
                                'title' => $this->cleanString($record->Title ?? $record->Subject ?? ''),
                                'description' => $this->cleanString($record->Description ?? $record->Details ?? ''),
                                'scheduled_date' => $this->parseDate($record->ScheduledDate ?? null),
                                'started_at' => $this->parseDateTime($record->StartedAt ?? $record->DateStarted ?? null),
                                'completed_at' => $this->parseDateTime($record->CompletedAt ?? $record->DateCompleted ?? null),
                                'assigned_to' => $this->cleanString($record->AssignedTo ?? null),
                                'estimated_cost' => $record->EstimatedCost ?? null,
                                'actual_cost' => $record->ActualCost ?? null,
                                'status' => $this->mapWorkOrderStatus($record->Status ?? 'pending'),
                                'notes' => $this->cleanString($record->Notes ?? $record->Remarks ?? null),
                                'created_at' => $this->parseDate($record->DateCreated ?? null) ?? now(),
                                'updated_at' => now(),
                            ];

                            WorkOrder::create($data);
                            $this->stats[$tableName]['success']++;
                        } catch (Exception $e) {
                            $this->stats[$tableName]['failed']++;
                            $this->logError($tableName, $record->id ?? 'unknown', $e->getMessage());
                        }
                    }
                });
            });

        $this->log("Work orders migration completed: {$this->stats[$tableName]['success']} success");
    }

    /**
     * Clean and validate migrated data
     */
    public function cleanupData(): void
    {
        $this->log('Running data cleanup...');

        // Update invoice statuses based on amount_paid
        Invoice::where('amount_paid', '>=', DB::raw('total_amount'))
            ->update(['status' => 'paid']);

        Invoice::where('amount_paid', '>', 0)
            ->where('amount_paid', '<', DB::raw('total_amount'))
            ->update(['status' => 'partially_paid']);

        // Update unit statuses based on active lease contracts
        $occupiedUnitIds = DB::table('lease_contract_unit')
            ->join('lease_contracts', 'lease_contract_unit.lease_contract_id', '=', 'lease_contracts.id')
            ->where('lease_contracts.status', 'active')
            ->pluck('lease_contract_unit.unit_id');

        Unit::whereIn('id', $occupiedUnitIds)->update(['status' => 'occupied']);

        $this->log('Data cleanup completed');
    }

    /**
     * Generate migration report with stats
     */
    public function generateReport(): array
    {
        $report = [
            'summary' => [
                'total_records' => array_sum(array_column($this->stats, 'total')),
                'total_success' => array_sum(array_column($this->stats, 'success')),
                'total_failed' => array_sum(array_column($this->stats, 'failed')),
                'total_skipped' => array_sum(array_column($this->stats, 'skipped')),
            ],
            'details' => $this->stats,
            'errors' => $this->errors,
        ];

        $this->log('Migration Report: ' . json_encode($report['summary'], JSON_PRETTY_PRINT));

        return $report;
    }

    // Helper methods

    protected function findNewPropertyId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }

        // Map legacy property IDs to new property IDs
        // This is a simple approach - you might want to use a mapping table
        return Property::where('id', $legacyId)->value('id');
    }

    protected function findNewBuildingId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }

        return Building::where('id', $legacyId)->value('id');
    }

    protected function findNewUnitId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }

        return Unit::where('id', $legacyId)->value('id');
    }

    protected function findNewTenantId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }

        return Tenant::where('id', $legacyId)->value('id');
    }

    protected function findNewInvoiceId(?int $legacyId): ?int
    {
        if (!$legacyId) {
            return null;
        }

        return Invoice::where('id', $legacyId)->value('id');
    }

    protected function cleanString(?string $value): ?string
    {
        if (!$value || trim($value) === '') {
            return config('legacy.null_empty_strings') ? null : $value;
        }

        return config('legacy.trim_strings') ? trim($value) : $value;
    }

    protected function cleanEmail(?string $email): ?string
    {
        $email = $this->cleanString($email);

        if (!$email) {
            return null;
        }

        if (config('legacy.validate_emails') && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        return strtolower($email);
    }

    protected function parseDate($value)
    {
        if (!$value || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->startOfDay();
        } catch (Exception $e) {
            return null;
        }
    }

    protected function parseDateTime($value)
    {
        if (!$value || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value);
        } catch (Exception $e) {
            return null;
        }
    }

    protected function mapStatus(?string $status): string
    {
        $statusMap = [
            'active' => 'active',
            'Active' => 'active',
            'inactive' => 'inactive',
            'Inactive' => 'inactive',
            'deleted' => 'inactive',
            'Deleted' => 'inactive',
        ];

        return $statusMap[$status] ?? 'active';
    }

    protected function mapInquiryStatus(?string $status): string
    {
        $statusMap = [
            'new' => 'new',
            'New' => 'new',
            'contacted' => 'contacted',
            'Contacted' => 'contacted',
            'qualified' => 'qualified',
            'Qualified' => 'qualified',
            'converted' => 'converted',
            'Converted' => 'converted',
            'lost' => 'lost',
            'Lost' => 'lost',
        ];

        return $statusMap[$status] ?? 'new';
    }

    protected function mapReservationStatus(?string $status): string
    {
        $statusMap = [
            'pending' => 'pending',
            'Pending' => 'pending',
            'confirmed' => 'confirmed',
            'Confirmed' => 'confirmed',
            'expired' => 'expired',
            'Expired' => 'expired',
            'cancelled' => 'cancelled',
            'Cancelled' => 'cancelled',
            'converted' => 'converted',
            'Converted' => 'converted',
        ];

        return $statusMap[$status] ?? 'pending';
    }

    protected function mapLeaseApplicationStatus(?string $status): string
    {
        $statusMap = [
            'pending' => 'pending',
            'Pending' => 'pending',
            'under_review' => 'under_review',
            'Under Review' => 'under_review',
            'approved' => 'approved',
            'Approved' => 'approved',
            'rejected' => 'rejected',
            'Rejected' => 'rejected',
            'withdrawn' => 'withdrawn',
            'Withdrawn' => 'withdrawn',
        ];

        return $statusMap[$status] ?? 'pending';
    }

    protected function mapPriority(?string $priority): string
    {
        $priorityMap = [
            'low' => 'low',
            'Low' => 'low',
            'medium' => 'medium',
            'Medium' => 'medium',
            'high' => 'high',
            'High' => 'high',
            'urgent' => 'urgent',
            'Urgent' => 'urgent',
        ];

        return $priorityMap[$priority] ?? 'medium';
    }

    protected function mapMaintenanceRequestStatus(?string $status): string
    {
        $statusMap = [
            'pending' => 'pending',
            'Pending' => 'pending',
            'assigned' => 'assigned',
            'Assigned' => 'assigned',
            'in_progress' => 'in_progress',
            'In Progress' => 'in_progress',
            'completed' => 'completed',
            'Completed' => 'completed',
            'cancelled' => 'cancelled',
            'Cancelled' => 'cancelled',
        ];

        return $statusMap[$status] ?? 'pending';
    }

    protected function mapWorkOrderType(?string $type): string
    {
        $typeMap = [
            'corrective' => 'corrective',
            'Corrective' => 'corrective',
            'preventive' => 'preventive',
            'Preventive' => 'preventive',
            'emergency' => 'emergency',
            'Emergency' => 'emergency',
            'inspection' => 'inspection',
            'Inspection' => 'inspection',
        ];

        return $typeMap[$type] ?? 'corrective';
    }

    protected function mapWorkOrderStatus(?string $status): string
    {
        $statusMap = [
            'pending' => 'pending',
            'Pending' => 'pending',
            'scheduled' => 'scheduled',
            'Scheduled' => 'scheduled',
            'in_progress' => 'in_progress',
            'In Progress' => 'in_progress',
            'completed' => 'completed',
            'Completed' => 'completed',
            'cancelled' => 'cancelled',
            'Cancelled' => 'cancelled',
        ];

        return $statusMap[$status] ?? 'pending';
    }

    protected function tableExists(string $connection, string $table): bool
    {
        try {
            return DB::connection($connection)->getSchemaBuilder()->hasTable($table);
        } catch (Exception $e) {
            return false;
        }
    }

    protected function log(string $message, string $level = 'info'): void
    {
        if (config('legacy.log_errors')) {
            Log::channel('single')->$level("[Migration] $message");
        }
    }

    protected function logError(string $table, $legacyId, string $message): void
    {
        $error = [
            'table' => $table,
            'legacy_id' => $legacyId,
            'message' => $message,
            'timestamp' => now()->toDateTimeString(),
        ];

        $this->errors[] = $error;
        $this->log("Error in {$table} (ID: {$legacyId}): {$message}", 'error');
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
