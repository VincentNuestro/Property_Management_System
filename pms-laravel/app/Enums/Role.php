<?php

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'Super Admin';
    case PROPERTY_MANAGER = 'Property Manager';
    case ACCOUNTANT = 'Accountant';
    case LEASING_OFFICER = 'Leasing Officer';
    case MAINTENANCE_STAFF = 'Maintenance Staff';
    case TENANT = 'Tenant';

    public function description(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Full system access with all permissions',
            self::PROPERTY_MANAGER => 'Manage properties, units, leases, and maintenance',
            self::ACCOUNTANT => 'Manage billing, payments, and financial reports',
            self::LEASING_OFFICER => 'Manage inquiries, reservations, and lease applications',
            self::MAINTENANCE_STAFF => 'View and update maintenance requests and work orders',
            self::TENANT => 'View own lease, invoices, payments, and submit maintenance requests',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($role) => ['value' => $role->value, 'label' => $role->value, 'description' => $role->description()],
            self::cases()
        );
    }
}
