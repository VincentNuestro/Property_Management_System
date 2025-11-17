<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\Role as RoleEnum;
use App\Enums\Permission as PermissionClass;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create all permissions
        $this->createPermissions();

        // Create roles and assign permissions
        $this->createRoles();

        $this->command->info('Roles and permissions created successfully!');
    }

    /**
     * Create all permissions
     */
    private function createPermissions(): void
    {
        $permissions = PermissionClass::allFlat();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $this->command->info('Created ' . count($permissions) . ' permissions');
    }

    /**
     * Create roles and assign permissions
     */
    private function createRoles(): void
    {
        // Super Admin - All permissions
        $superAdmin = Role::firstOrCreate([
            'name' => RoleEnum::SUPER_ADMIN->value,
            'guard_name' => 'web'
        ]);
        $superAdmin->givePermissionTo(Permission::all());
        $this->command->info('Created Super Admin role with all permissions');

        // Property Manager - Manage properties, units, leases, maintenance
        $propertyManager = Role::firstOrCreate([
            'name' => RoleEnum::PROPERTY_MANAGER->value,
            'guard_name' => 'web'
        ]);
        $propertyManager->givePermissionTo([
            // Properties
            PermissionClass::PROPERTIES_VIEW,
            PermissionClass::PROPERTIES_CREATE,
            PermissionClass::PROPERTIES_EDIT,
            PermissionClass::BUILDINGS_VIEW,
            PermissionClass::BUILDINGS_CREATE,
            PermissionClass::BUILDINGS_EDIT,
            PermissionClass::FLOORS_VIEW,
            PermissionClass::FLOORS_CREATE,
            PermissionClass::FLOORS_EDIT,
            PermissionClass::UNITS_VIEW,
            PermissionClass::UNITS_CREATE,
            PermissionClass::UNITS_EDIT,

            // Tenants
            PermissionClass::COMPANIES_VIEW,
            PermissionClass::COMPANIES_CREATE,
            PermissionClass::COMPANIES_EDIT,
            PermissionClass::TENANTS_VIEW,
            PermissionClass::TENANTS_CREATE,
            PermissionClass::TENANTS_EDIT,

            // Leases
            PermissionClass::INQUIRIES_VIEW,
            PermissionClass::INQUIRIES_CREATE,
            PermissionClass::INQUIRIES_EDIT,
            PermissionClass::INQUIRIES_ASSIGN,
            PermissionClass::RESERVATIONS_VIEW,
            PermissionClass::RESERVATIONS_CREATE,
            PermissionClass::RESERVATIONS_EDIT,
            PermissionClass::RESERVATIONS_CONVERT,
            PermissionClass::LEASE_APPLICATIONS_VIEW,
            PermissionClass::LEASE_APPLICATIONS_CREATE,
            PermissionClass::LEASE_APPLICATIONS_EDIT,
            PermissionClass::LEASE_APPLICATIONS_REVIEW,
            PermissionClass::LEASE_APPLICATIONS_APPROVE,
            PermissionClass::LEASE_CONTRACTS_VIEW,
            PermissionClass::LEASE_CONTRACTS_CREATE,
            PermissionClass::LEASE_CONTRACTS_EDIT,
            PermissionClass::LEASE_CONTRACTS_TERMINATE,
            PermissionClass::LEASE_CONTRACTS_RENEW,

            // Maintenance
            PermissionClass::MAINTENANCE_REQUESTS_VIEW,
            PermissionClass::MAINTENANCE_REQUESTS_CREATE,
            PermissionClass::MAINTENANCE_REQUESTS_EDIT,
            PermissionClass::MAINTENANCE_REQUESTS_ASSIGN,
            PermissionClass::MAINTENANCE_REQUESTS_COMPLETE,
            PermissionClass::WORK_ORDERS_VIEW,
            PermissionClass::WORK_ORDERS_CREATE,
            PermissionClass::WORK_ORDERS_EDIT,
            PermissionClass::WORK_ORDERS_COMPLETE,

            // Reports (view only)
            PermissionClass::REPORTS_VIEW,
            PermissionClass::REPORTS_OCCUPANCY,
            PermissionClass::REPORTS_RENT_ROLL,
            PermissionClass::REPORTS_MAINTENANCE,

            // Activity Log
            PermissionClass::ACTIVITY_LOG_VIEW,
        ]);
        $this->command->info('Created Property Manager role');

        // Accountant - Manage billing, payments, financial reports
        $accountant = Role::firstOrCreate([
            'name' => RoleEnum::ACCOUNTANT->value,
            'guard_name' => 'web'
        ]);
        $accountant->givePermissionTo([
            // View related entities
            PermissionClass::PROPERTIES_VIEW,
            PermissionClass::UNITS_VIEW,
            PermissionClass::TENANTS_VIEW,
            PermissionClass::COMPANIES_VIEW,
            PermissionClass::LEASE_CONTRACTS_VIEW,

            // Charge Types
            PermissionClass::CHARGE_TYPES_VIEW,
            PermissionClass::CHARGE_TYPES_CREATE,
            PermissionClass::CHARGE_TYPES_EDIT,

            // Invoices
            PermissionClass::INVOICES_VIEW,
            PermissionClass::INVOICES_CREATE,
            PermissionClass::INVOICES_EDIT,
            PermissionClass::INVOICES_SEND,
            PermissionClass::INVOICES_VOID,

            // Penalties
            PermissionClass::PENALTIES_VIEW,
            PermissionClass::PENALTIES_CREATE,
            PermissionClass::PENALTIES_WAIVE,

            // Payments
            PermissionClass::PAYMENTS_VIEW,
            PermissionClass::PAYMENTS_CREATE,
            PermissionClass::PAYMENTS_EDIT,
            PermissionClass::PAYMENTS_APPLY,
            PermissionClass::PAYMENTS_VOID,

            // Receipts
            PermissionClass::RECEIPTS_VIEW,
            PermissionClass::RECEIPTS_CREATE,
            PermissionClass::RECEIPTS_PRINT,

            // Reports
            PermissionClass::REPORTS_VIEW,
            PermissionClass::REPORTS_AGING,
            PermissionClass::REPORTS_COLLECTIONS,
            PermissionClass::REPORTS_FINANCIAL,
            PermissionClass::REPORTS_RENT_ROLL,

            // Activity Log
            PermissionClass::ACTIVITY_LOG_VIEW,
        ]);
        $this->command->info('Created Accountant role');

        // Leasing Officer - Manage inquiries, reservations, applications
        $leasingOfficer = Role::firstOrCreate([
            'name' => RoleEnum::LEASING_OFFICER->value,
            'guard_name' => 'web'
        ]);
        $leasingOfficer->givePermissionTo([
            // View related entities
            PermissionClass::PROPERTIES_VIEW,
            PermissionClass::UNITS_VIEW,

            // Companies & Tenants
            PermissionClass::COMPANIES_VIEW,
            PermissionClass::COMPANIES_CREATE,
            PermissionClass::COMPANIES_EDIT,
            PermissionClass::TENANTS_VIEW,
            PermissionClass::TENANTS_CREATE,
            PermissionClass::TENANTS_EDIT,

            // Inquiries
            PermissionClass::INQUIRIES_VIEW,
            PermissionClass::INQUIRIES_CREATE,
            PermissionClass::INQUIRIES_EDIT,
            PermissionClass::INQUIRIES_ASSIGN,

            // Reservations
            PermissionClass::RESERVATIONS_VIEW,
            PermissionClass::RESERVATIONS_CREATE,
            PermissionClass::RESERVATIONS_EDIT,
            PermissionClass::RESERVATIONS_CONVERT,

            // Lease Applications
            PermissionClass::LEASE_APPLICATIONS_VIEW,
            PermissionClass::LEASE_APPLICATIONS_CREATE,
            PermissionClass::LEASE_APPLICATIONS_EDIT,
            PermissionClass::LEASE_APPLICATIONS_REVIEW,

            // Lease Contracts (view only)
            PermissionClass::LEASE_CONTRACTS_VIEW,

            // Reports
            PermissionClass::REPORTS_VIEW,
            PermissionClass::REPORTS_OCCUPANCY,
        ]);
        $this->command->info('Created Leasing Officer role');

        // Maintenance Staff - View and update maintenance requests and work orders
        $maintenanceStaff = Role::firstOrCreate([
            'name' => RoleEnum::MAINTENANCE_STAFF->value,
            'guard_name' => 'web'
        ]);
        $maintenanceStaff->givePermissionTo([
            // View related entities
            PermissionClass::PROPERTIES_VIEW,
            PermissionClass::UNITS_VIEW,

            // Maintenance Requests
            PermissionClass::MAINTENANCE_REQUESTS_VIEW,
            PermissionClass::MAINTENANCE_REQUESTS_EDIT,
            PermissionClass::MAINTENANCE_REQUESTS_COMPLETE,

            // Work Orders
            PermissionClass::WORK_ORDERS_VIEW,
            PermissionClass::WORK_ORDERS_EDIT,
            PermissionClass::WORK_ORDERS_COMPLETE,

            // Reports
            PermissionClass::REPORTS_VIEW,
            PermissionClass::REPORTS_MAINTENANCE,
        ]);
        $this->command->info('Created Maintenance Staff role');

        // Tenant - Limited view access to own data
        $tenant = Role::firstOrCreate([
            'name' => RoleEnum::TENANT->value,
            'guard_name' => 'web'
        ]);
        $tenant->givePermissionTo([
            // View own lease contract
            PermissionClass::LEASE_CONTRACTS_VIEW,

            // View own invoices
            PermissionClass::INVOICES_VIEW,

            // View own payments and receipts
            PermissionClass::PAYMENTS_VIEW,
            PermissionClass::RECEIPTS_VIEW,

            // Submit maintenance requests
            PermissionClass::MAINTENANCE_REQUESTS_VIEW,
            PermissionClass::MAINTENANCE_REQUESTS_CREATE,
        ]);
        $this->command->info('Created Tenant role');

        $this->command->info('All roles created and permissions assigned!');
    }
}
