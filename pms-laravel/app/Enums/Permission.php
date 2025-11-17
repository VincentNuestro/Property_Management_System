<?php

namespace App\Enums;

class Permission
{
    // Property Management
    public const PROPERTIES_VIEW = 'properties.view';
    public const PROPERTIES_CREATE = 'properties.create';
    public const PROPERTIES_EDIT = 'properties.edit';
    public const PROPERTIES_DELETE = 'properties.delete';

    // Building Management
    public const BUILDINGS_VIEW = 'buildings.view';
    public const BUILDINGS_CREATE = 'buildings.create';
    public const BUILDINGS_EDIT = 'buildings.edit';
    public const BUILDINGS_DELETE = 'buildings.delete';

    // Floor Management
    public const FLOORS_VIEW = 'floors.view';
    public const FLOORS_CREATE = 'floors.create';
    public const FLOORS_EDIT = 'floors.edit';
    public const FLOORS_DELETE = 'floors.delete';

    // Unit Management
    public const UNITS_VIEW = 'units.view';
    public const UNITS_CREATE = 'units.create';
    public const UNITS_EDIT = 'units.edit';
    public const UNITS_DELETE = 'units.delete';

    // Company Management
    public const COMPANIES_VIEW = 'companies.view';
    public const COMPANIES_CREATE = 'companies.create';
    public const COMPANIES_EDIT = 'companies.edit';
    public const COMPANIES_DELETE = 'companies.delete';

    // Tenant Management
    public const TENANTS_VIEW = 'tenants.view';
    public const TENANTS_CREATE = 'tenants.create';
    public const TENANTS_EDIT = 'tenants.edit';
    public const TENANTS_DELETE = 'tenants.delete';

    // Inquiry Management
    public const INQUIRIES_VIEW = 'inquiries.view';
    public const INQUIRIES_CREATE = 'inquiries.create';
    public const INQUIRIES_EDIT = 'inquiries.edit';
    public const INQUIRIES_DELETE = 'inquiries.delete';
    public const INQUIRIES_ASSIGN = 'inquiries.assign';

    // Reservation Management
    public const RESERVATIONS_VIEW = 'reservations.view';
    public const RESERVATIONS_CREATE = 'reservations.create';
    public const RESERVATIONS_EDIT = 'reservations.edit';
    public const RESERVATIONS_DELETE = 'reservations.delete';
    public const RESERVATIONS_CONVERT = 'reservations.convert';

    // Lease Application Management
    public const LEASE_APPLICATIONS_VIEW = 'lease_applications.view';
    public const LEASE_APPLICATIONS_CREATE = 'lease_applications.create';
    public const LEASE_APPLICATIONS_EDIT = 'lease_applications.edit';
    public const LEASE_APPLICATIONS_DELETE = 'lease_applications.delete';
    public const LEASE_APPLICATIONS_REVIEW = 'lease_applications.review';
    public const LEASE_APPLICATIONS_APPROVE = 'lease_applications.approve';

    // Lease Contract Management
    public const LEASE_CONTRACTS_VIEW = 'lease_contracts.view';
    public const LEASE_CONTRACTS_CREATE = 'lease_contracts.create';
    public const LEASE_CONTRACTS_EDIT = 'lease_contracts.edit';
    public const LEASE_CONTRACTS_DELETE = 'lease_contracts.delete';
    public const LEASE_CONTRACTS_TERMINATE = 'lease_contracts.terminate';
    public const LEASE_CONTRACTS_RENEW = 'lease_contracts.renew';

    // Charge Type Management
    public const CHARGE_TYPES_VIEW = 'charge_types.view';
    public const CHARGE_TYPES_CREATE = 'charge_types.create';
    public const CHARGE_TYPES_EDIT = 'charge_types.edit';
    public const CHARGE_TYPES_DELETE = 'charge_types.delete';

    // Invoice Management
    public const INVOICES_VIEW = 'invoices.view';
    public const INVOICES_CREATE = 'invoices.create';
    public const INVOICES_EDIT = 'invoices.edit';
    public const INVOICES_DELETE = 'invoices.delete';
    public const INVOICES_SEND = 'invoices.send';
    public const INVOICES_VOID = 'invoices.void';

    // Penalty Management
    public const PENALTIES_VIEW = 'penalties.view';
    public const PENALTIES_CREATE = 'penalties.create';
    public const PENALTIES_WAIVE = 'penalties.waive';

    // Payment Management
    public const PAYMENTS_VIEW = 'payments.view';
    public const PAYMENTS_CREATE = 'payments.create';
    public const PAYMENTS_EDIT = 'payments.edit';
    public const PAYMENTS_DELETE = 'payments.delete';
    public const PAYMENTS_APPLY = 'payments.apply';
    public const PAYMENTS_VOID = 'payments.void';

    // Receipt Management
    public const RECEIPTS_VIEW = 'receipts.view';
    public const RECEIPTS_CREATE = 'receipts.create';
    public const RECEIPTS_PRINT = 'receipts.print';

    // Maintenance Request Management
    public const MAINTENANCE_REQUESTS_VIEW = 'maintenance_requests.view';
    public const MAINTENANCE_REQUESTS_CREATE = 'maintenance_requests.create';
    public const MAINTENANCE_REQUESTS_EDIT = 'maintenance_requests.edit';
    public const MAINTENANCE_REQUESTS_DELETE = 'maintenance_requests.delete';
    public const MAINTENANCE_REQUESTS_ASSIGN = 'maintenance_requests.assign';
    public const MAINTENANCE_REQUESTS_COMPLETE = 'maintenance_requests.complete';

    // Work Order Management
    public const WORK_ORDERS_VIEW = 'work_orders.view';
    public const WORK_ORDERS_CREATE = 'work_orders.create';
    public const WORK_ORDERS_EDIT = 'work_orders.edit';
    public const WORK_ORDERS_DELETE = 'work_orders.delete';
    public const WORK_ORDERS_COMPLETE = 'work_orders.complete';

    // Reports
    public const REPORTS_VIEW = 'reports.view';
    public const REPORTS_OCCUPANCY = 'reports.occupancy';
    public const REPORTS_RENT_ROLL = 'reports.rent_roll';
    public const REPORTS_AGING = 'reports.aging';
    public const REPORTS_COLLECTIONS = 'reports.collections';
    public const REPORTS_MAINTENANCE = 'reports.maintenance';
    public const REPORTS_FINANCIAL = 'reports.financial';

    // User Management
    public const USERS_VIEW = 'users.view';
    public const USERS_CREATE = 'users.create';
    public const USERS_EDIT = 'users.edit';
    public const USERS_DELETE = 'users.delete';

    // Role & Permission Management
    public const ROLES_VIEW = 'roles.view';
    public const ROLES_CREATE = 'roles.create';
    public const ROLES_EDIT = 'roles.edit';
    public const ROLES_DELETE = 'roles.delete';
    public const PERMISSIONS_ASSIGN = 'permissions.assign';

    // Activity Log
    public const ACTIVITY_LOG_VIEW = 'activity_log.view';

    /**
     * Get all permissions grouped by module
     */
    public static function all(): array
    {
        return [
            'Property Management' => [
                self::PROPERTIES_VIEW,
                self::PROPERTIES_CREATE,
                self::PROPERTIES_EDIT,
                self::PROPERTIES_DELETE,
                self::BUILDINGS_VIEW,
                self::BUILDINGS_CREATE,
                self::BUILDINGS_EDIT,
                self::BUILDINGS_DELETE,
                self::FLOORS_VIEW,
                self::FLOORS_CREATE,
                self::FLOORS_EDIT,
                self::FLOORS_DELETE,
                self::UNITS_VIEW,
                self::UNITS_CREATE,
                self::UNITS_EDIT,
                self::UNITS_DELETE,
            ],
            'Tenant Management' => [
                self::COMPANIES_VIEW,
                self::COMPANIES_CREATE,
                self::COMPANIES_EDIT,
                self::COMPANIES_DELETE,
                self::TENANTS_VIEW,
                self::TENANTS_CREATE,
                self::TENANTS_EDIT,
                self::TENANTS_DELETE,
            ],
            'Lease Management' => [
                self::INQUIRIES_VIEW,
                self::INQUIRIES_CREATE,
                self::INQUIRIES_EDIT,
                self::INQUIRIES_DELETE,
                self::INQUIRIES_ASSIGN,
                self::RESERVATIONS_VIEW,
                self::RESERVATIONS_CREATE,
                self::RESERVATIONS_EDIT,
                self::RESERVATIONS_DELETE,
                self::RESERVATIONS_CONVERT,
                self::LEASE_APPLICATIONS_VIEW,
                self::LEASE_APPLICATIONS_CREATE,
                self::LEASE_APPLICATIONS_EDIT,
                self::LEASE_APPLICATIONS_DELETE,
                self::LEASE_APPLICATIONS_REVIEW,
                self::LEASE_APPLICATIONS_APPROVE,
                self::LEASE_CONTRACTS_VIEW,
                self::LEASE_CONTRACTS_CREATE,
                self::LEASE_CONTRACTS_EDIT,
                self::LEASE_CONTRACTS_DELETE,
                self::LEASE_CONTRACTS_TERMINATE,
                self::LEASE_CONTRACTS_RENEW,
            ],
            'Billing & Invoicing' => [
                self::CHARGE_TYPES_VIEW,
                self::CHARGE_TYPES_CREATE,
                self::CHARGE_TYPES_EDIT,
                self::CHARGE_TYPES_DELETE,
                self::INVOICES_VIEW,
                self::INVOICES_CREATE,
                self::INVOICES_EDIT,
                self::INVOICES_DELETE,
                self::INVOICES_SEND,
                self::INVOICES_VOID,
                self::PENALTIES_VIEW,
                self::PENALTIES_CREATE,
                self::PENALTIES_WAIVE,
            ],
            'Payments' => [
                self::PAYMENTS_VIEW,
                self::PAYMENTS_CREATE,
                self::PAYMENTS_EDIT,
                self::PAYMENTS_DELETE,
                self::PAYMENTS_APPLY,
                self::PAYMENTS_VOID,
                self::RECEIPTS_VIEW,
                self::RECEIPTS_CREATE,
                self::RECEIPTS_PRINT,
            ],
            'Maintenance' => [
                self::MAINTENANCE_REQUESTS_VIEW,
                self::MAINTENANCE_REQUESTS_CREATE,
                self::MAINTENANCE_REQUESTS_EDIT,
                self::MAINTENANCE_REQUESTS_DELETE,
                self::MAINTENANCE_REQUESTS_ASSIGN,
                self::MAINTENANCE_REQUESTS_COMPLETE,
                self::WORK_ORDERS_VIEW,
                self::WORK_ORDERS_CREATE,
                self::WORK_ORDERS_EDIT,
                self::WORK_ORDERS_DELETE,
                self::WORK_ORDERS_COMPLETE,
            ],
            'Reports' => [
                self::REPORTS_VIEW,
                self::REPORTS_OCCUPANCY,
                self::REPORTS_RENT_ROLL,
                self::REPORTS_AGING,
                self::REPORTS_COLLECTIONS,
                self::REPORTS_MAINTENANCE,
                self::REPORTS_FINANCIAL,
            ],
            'User & Role Management' => [
                self::USERS_VIEW,
                self::USERS_CREATE,
                self::USERS_EDIT,
                self::USERS_DELETE,
                self::ROLES_VIEW,
                self::ROLES_CREATE,
                self::ROLES_EDIT,
                self::ROLES_DELETE,
                self::PERMISSIONS_ASSIGN,
            ],
            'System' => [
                self::ACTIVITY_LOG_VIEW,
            ],
        ];
    }

    /**
     * Get all permissions as a flat array
     */
    public static function allFlat(): array
    {
        return array_merge(...array_values(self::all()));
    }
}
