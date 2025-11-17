# Laravel 11 Property Management System - Architecture Design

**Version:** 1.0
**Date:** November 17, 2025
**Target Stack:** Laravel 11, PHP 8.2+, MariaDB, Tailwind CSS

---

## Table of Contents

1. [Technology Stack](#1-technology-stack)
2. [Architecture Overview](#2-architecture-overview)
3. [Project Structure](#3-project-structure)
4. [Database Design](#4-database-design)
5. [Authentication & Authorization](#5-authentication--authorization)
6. [Frontend Architecture](#6-frontend-architecture)
7. [Backend Architecture](#7-backend-architecture)
8. [Module Design](#8-module-design)
9. [Security Strategy](#9-security-strategy)
10. [Performance Optimization](#10-performance-optimization)
11. [Testing Strategy](#11-testing-strategy)
12. [Deployment Architecture](#12-deployment-architecture)

---

## 1. Technology Stack

### 1.1 Backend

| Component | Technology | Version | Justification |
|-----------|-----------|---------|---------------|
| Framework | **Laravel** | 11.x | Latest stable, modern features, excellent docs |
| Language | **PHP** | 8.2+ | Modern PHP with typed properties, enums, readonly |
| Database | **MariaDB** | 11.x | MySQL-compatible, better performance, open-source |
| Cache | **Redis** | 7.x | Session storage, caching, queue driver |
| Queue | **Redis** | 7.x | Background jobs for billing, notifications |
| Search | **Laravel Scout** | - | Full-text search (optional: Meilisearch) |
| PDF | **Barryvdh DomPDF** | - | Invoice and report generation |
| Excel | **Maatwebsite Excel** | - | Excel export/import |

### 1.2 Frontend

| Component | Technology | Justification |
|-----------|-----------|---------------|
| UI Framework | **Blade + Tailwind CSS** | **✅ RECOMMENDED** |
| Alternative | Inertia.js + Vue 3 | SPA experience (optional) |

**Decision: Blade + Tailwind CSS**

**Rationale:**
- **Simplicity:** Faster development, less complexity
- **SEO-Friendly:** Server-side rendering out of the box
- **Laravel Integration:** Native support, excellent blade components
- **Performance:** Fast initial page load, progressive enhancement
- **Team Velocity:** Easier onboarding, less JavaScript overhead
- **Livewire Compatible:** Can add reactive components later if needed

**When to use Inertia + Vue 3:**
- If you need a highly interactive, SPA-like experience
- If mobile app will share Vue components
- If team has strong Vue expertise

**Our Choice:** Start with Blade + Tailwind, optionally add Livewire for reactive components.

### 1.3 Authentication & Scaffolding

**Choice: Laravel Breeze**

| Feature | Breeze | Jetstream |
|---------|--------|-----------|
| Complexity | ✅ Simple | Complex |
| Features | Auth basics | Teams, 2FA, API tokens |
| Customization | ✅ Easy | Harder (Livewire/Inertia) |
| Learning Curve | ✅ Low | Steep |
| Bundle Size | ✅ Minimal | Large |

**Decision: Laravel Breeze (Blade + Tailwind)**

**Rationale:**
- **Minimal Footprint:** Only what we need
- **Easy Customization:** Simple blade templates
- **No Overhead:** No unused features (teams, API tokens)
- **Perfect for Internal Apps:** PMS is not a SaaS (yet)
- **Can Upgrade:** If teams needed later, can add Jetstream features manually

### 1.4 Additional Packages

```json
{
  "require": {
    "laravel/framework": "^11.0",
    "laravel/breeze": "^2.0",
    "spatie/laravel-permission": "^6.0",        // Role-based access control
    "spatie/laravel-activitylog": "^4.0",       // Audit trail
    "spatie/laravel-query-builder": "^5.0",     // API filtering
    "barryvdh/laravel-dompdf": "^2.0",          // PDF generation
    "maatwebsite/excel": "^3.1",                // Excel export
    "intervention/image": "^3.0",               // Image processing
    "propaganistas/laravel-phone": "^5.0",      // Phone validation
    "akaunting/laravel-money": "^5.0"           // Money formatting
  },
  "require-dev": {
    "laravel/pint": "^1.0",                     // Code style
    "laravel/telescope": "^5.0",                // Debugging (local only)
    "pestphp/pest": "^2.0",                     // Testing framework
    "pestphp/pest-plugin-laravel": "^2.0"
  }
}
```

---

## 2. Architecture Overview

### 2.1 Architectural Pattern

**Clean Architecture with Domain-Driven Design (DDD) Principles**

```
┌─────────────────────────────────────────────────────────────┐
│                     Presentation Layer                      │
│  (Controllers, Requests, Resources, Blade Views)            │
└──────────────────────┬──────────────────────────────────────┘
                       │
┌──────────────────────┴──────────────────────────────────────┐
│                    Application Layer                        │
│         (Services, Actions, DTOs, Events)                   │
└──────────────────────┬──────────────────────────────────────┘
                       │
┌──────────────────────┴──────────────────────────────────────┐
│                      Domain Layer                           │
│    (Models, Enums, Value Objects, Business Rules)           │
└──────────────────────┬──────────────────────────────────────┘
                       │
┌──────────────────────┴──────────────────────────────────────┐
│                  Infrastructure Layer                       │
│  (Database, Cache, Queue, External Services)                │
└─────────────────────────────────────────────────────────────┘
```

### 2.2 Key Principles

1. **Separation of Concerns:** Each layer has a single responsibility
2. **Dependency Injection:** Loose coupling via Laravel's container
3. **Single Responsibility:** Each class does one thing well
4. **DRY (Don't Repeat Yourself):** Reusable components and traits
5. **SOLID Principles:** Maintainable and extensible code
6. **Convention over Configuration:** Laravel conventions for consistency

---

## 3. Project Structure

### 3.1 Directory Structure

```
app/
├── Actions/                      # Single-purpose action classes
│   ├── Billing/
│   │   ├── GenerateMonthlyInvoicesAction.php
│   │   ├── CalculateLatePenaltyAction.php
│   │   └── ApplyPaymentToInvoiceAction.php
│   ├── Lease/
│   │   ├── CreateLeaseContractAction.php
│   │   └── TerminateLeaseAction.php
│   └── Unit/
│       └── CheckUnitAvailabilityAction.php
│
├── DataTransferObjects/          # DTOs for data passing
│   ├── Billing/
│   │   ├── InvoiceData.php
│   │   └── PaymentData.php
│   └── Lease/
│       └── LeaseContractData.php
│
├── Enums/                        # PHP 8.2 Enums
│   ├── InvoiceStatus.php
│   ├── LeaseStatus.php
│   ├── PaymentMethod.php
│   ├── UnitStatus.php
│   └── UserRole.php
│
├── Events/                       # Domain events
│   ├── LeaseCreated.php
│   ├── InvoiceGenerated.php
│   ├── PaymentReceived.php
│   └── LeaseTerminated.php
│
├── Http/
│   ├── Controllers/
│   │   ├── API/                  # API controllers (optional)
│   │   ├── Dashboard/
│   │   │   └── DashboardController.php
│   │   ├── Property/
│   │   │   ├── PropertyController.php
│   │   │   ├── BuildingController.php
│   │   │   └── UnitController.php
│   │   ├── Tenant/
│   │   │   └── TenantController.php
│   │   ├── Lease/
│   │   │   ├── InquiryController.php
│   │   │   ├── ReservationController.php
│   │   │   ├── LeaseApplicationController.php
│   │   │   └── LeaseContractController.php
│   │   ├── Billing/
│   │   │   ├── InvoiceController.php
│   │   │   └── ChargeController.php
│   │   ├── Payment/
│   │   │   ├── PaymentController.php
│   │   │   └── ReceiptController.php
│   │   ├── Maintenance/
│   │   │   ├── WorkOrderController.php
│   │   │   └── MaintenanceRequestController.php
│   │   ├── Report/
│   │   │   ├── OccupancyReportController.php
│   │   │   ├── RentRollReportController.php
│   │   │   └── AgingReportController.php
│   │   └── Settings/
│   │       ├── UserController.php
│   │       ├── RoleController.php
│   │       └── SystemSettingController.php
│   │
│   ├── Requests/                 # Form validation
│   │   ├── Property/
│   │   ├── Tenant/
│   │   ├── Lease/
│   │   ├── Billing/
│   │   └── Payment/
│   │
│   ├── Resources/                # API resources (JSON responses)
│   │   ├── PropertyResource.php
│   │   ├── TenantResource.php
│   │   └── InvoiceResource.php
│   │
│   └── Middleware/
│       ├── CheckPropertyAccess.php
│       └── LogUserActivity.php
│
├── Jobs/                         # Queue jobs
│   ├── GenerateMonthlyBillingJob.php
│   ├── SendInvoiceEmailJob.php
│   ├── CalculateAgingReportJob.php
│   └── ProcessBulkPaymentJob.php
│
├── Listeners/                    # Event listeners
│   ├── SendLeaseCreatedNotification.php
│   ├── UpdateUnitStatus.php
│   └── LogPaymentReceived.php
│
├── Models/
│   ├── Property.php
│   ├── Building.php
│   ├── Floor.php
│   ├── Unit.php
│   ├── Tenant.php
│   ├── Company.php
│   ├── Inquiry.php
│   ├── Reservation.php
│   ├── LeaseApplication.php
│   ├── LeaseContract.php
│   ├── ContractCharge.php
│   ├── Invoice.php
│   ├── InvoiceLineItem.php
│   ├── Payment.php
│   ├── PaymentApplication.php
│   ├── WorkOrder.php
│   ├── MaintenanceRequest.php
│   └── User.php
│
├── Observers/                    # Model observers
│   ├── LeaseContractObserver.php
│   ├── InvoiceObserver.php
│   └── PaymentObserver.php
│
├── Policies/                     # Authorization policies
│   ├── PropertyPolicy.php
│   ├── TenantPolicy.php
│   ├── LeaseContractPolicy.php
│   └── InvoicePolicy.php
│
├── Providers/
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   ├── EventServiceProvider.php
│   └── RouteServiceProvider.php
│
├── Services/                     # Business logic services
│   ├── Billing/
│   │   ├── InvoiceService.php
│   │   ├── PenaltyCalculationService.php
│   │   └── ProrationService.php
│   ├── Lease/
│   │   ├── LeaseService.php
│   │   └── RenewalService.php
│   ├── Payment/
│   │   └── PaymentService.php
│   ├── Report/
│   │   ├── OccupancyReportService.php
│   │   ├── RentRollService.php
│   │   └── AgingReportService.php
│   └── Notification/
│       └── NotificationService.php
│
├── Traits/                       # Reusable traits
│   ├── HasPropertyScope.php
│   ├── HasAuditLog.php
│   └── Searchable.php
│
└── ValueObjects/                 # Immutable value objects
    ├── Money.php
    ├── Address.php
    └── PhoneNumber.php

database/
├── factories/                    # Model factories for testing
├── migrations/
│   ├── 2025_01_01_000001_create_properties_table.php
│   ├── 2025_01_01_000002_create_buildings_table.php
│   ├── 2025_01_01_000003_create_floors_table.php
│   ├── 2025_01_01_000004_create_units_table.php
│   ├── 2025_01_01_000010_create_tenants_table.php
│   ├── 2025_01_01_000020_create_lease_contracts_table.php
│   ├── 2025_01_01_000030_create_invoices_table.php
│   ├── 2025_01_01_000040_create_payments_table.php
│   └── ...
└── seeders/
    ├── DatabaseSeeder.php
    ├── PropertySeeder.php
    ├── RoleAndPermissionSeeder.php
    └── UserSeeder.php

resources/
├── css/
│   └── app.css                   # Tailwind CSS
├── js/
│   ├── app.js                    # Alpine.js, custom scripts
│   └── components/               # Reusable JS components
└── views/
    ├── layouts/
    │   ├── app.blade.php         # Main layout
    │   ├── guest.blade.php       # Guest layout
    │   └── print.blade.php       # Print layout
    ├── components/
    │   ├── sidebar.blade.php
    │   ├── navbar.blade.php
    │   ├── table.blade.php
    │   ├── form/
    │   │   ├── input.blade.php
    │   │   ├── select.blade.php
    │   │   ├── textarea.blade.php
    │   │   └── datepicker.blade.php
    │   └── modal.blade.php
    ├── dashboard/
    │   └── index.blade.php
    ├── properties/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── show.blade.php
    ├── tenants/
    ├── leases/
    ├── billing/
    ├── payments/
    ├── maintenance/
    ├── reports/
    └── settings/

routes/
├── web.php                       # Web routes
├── api.php                       # API routes (optional)
└── console.php                   # Console commands

tests/
├── Feature/                      # Feature tests
│   ├── Lease/
│   │   └── CreateLeaseContractTest.php
│   ├── Billing/
│   │   └── GenerateInvoiceTest.php
│   └── Payment/
│       └── RecordPaymentTest.php
└── Unit/                         # Unit tests
    ├── Services/
    └── Actions/

config/
├── app.php
├── database.php
├── permission.php                # Spatie permission config
└── pms.php                       # Custom PMS settings
```

---

## 4. Database Design

### 4.1 Naming Conventions (Laravel Standard)

**Tables:** `snake_case`, plural
- ✅ `properties`, `lease_contracts`, `invoice_line_items`
- ❌ `tblProperties`, `LeaseContracts`, `tblref_unit`

**Columns:** `snake_case`
- ✅ `property_name`, `created_at`, `total_amount`
- ❌ `PropertyName`, `vcPropertyName`, `fTotalAmount`

**Primary Keys:** `id` (auto-increment)

**Foreign Keys:** `{table_singular}_id`
- ✅ `property_id`, `tenant_id`, `lease_contract_id`

**Timestamps:** `created_at`, `updated_at`, `deleted_at` (soft deletes)

### 4.2 Core Tables

#### **4.2.1 Property Management**

```sql
-- Properties (formerly tblref_mall)
CREATE TABLE properties (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    type ENUM('mall', 'office_building', 'residential', 'mixed_use', 'industrial') NOT NULL,
    address_line1 VARCHAR(255),
    address_line2 VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100) DEFAULT 'Philippines',
    phone VARCHAR(50),
    email VARCHAR(255),
    tax_id VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    INDEX idx_code (code),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Buildings (formerly tblref_bldg)
CREATE TABLE buildings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    total_floors INT UNSIGNED DEFAULT 0,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    UNIQUE KEY unique_building_code (property_id, code),
    INDEX idx_property (property_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Floors (formerly tblref_floorsetup)
CREATE TABLE floors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    building_id BIGINT UNSIGNED NOT NULL,
    floor_number INT NOT NULL,
    floor_name VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (building_id) REFERENCES buildings(id) ON DELETE CASCADE,
    UNIQUE KEY unique_floor_number (building_id, floor_number),
    INDEX idx_building (building_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Units (formerly tblref_unit)
CREATE TABLE units (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    building_id BIGINT UNSIGNED,
    floor_id BIGINT UNSIGNED,
    unit_code VARCHAR(100) UNIQUE NOT NULL,
    unit_number VARCHAR(100) NOT NULL,
    type ENUM('commercial', 'office', 'residential', 'parking', 'storage', 'kiosk') NOT NULL,
    classification VARCHAR(100),
    area_sqm DECIMAL(10, 2),
    bedrooms INT UNSIGNED DEFAULT 0,
    bathrooms INT UNSIGNED DEFAULT 0,
    status ENUM('vacant', 'occupied', 'reserved', 'maintenance', 'unavailable') DEFAULT 'vacant',
    base_rent DECIMAL(15, 2) DEFAULT 0.00,
    association_dues DECIMAL(15, 2) DEFAULT 0.00,
    description TEXT,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (building_id) REFERENCES buildings(id) ON DELETE SET NULL,
    FOREIGN KEY (floor_id) REFERENCES floors(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_building (building_id),
    INDEX idx_floor (floor_id),
    INDEX idx_status (status),
    INDEX idx_type (type),
    INDEX idx_unit_code (unit_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### **4.2.2 Tenant Management**

```sql
-- Tenants (formerly tbltrans_tenants - individuals/contact persons)
CREATE TABLE tenants (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_type ENUM('individual', 'corporate') NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    company_id BIGINT UNSIGNED,                -- If corporate
    email VARCHAR(255),
    phone VARCHAR(50),
    mobile VARCHAR(50),
    address_line1 VARCHAR(255),
    address_line2 VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100) DEFAULT 'Philippines',
    government_id_type VARCHAR(50),
    government_id_number VARCHAR(100),
    date_of_birth DATE,
    nationality VARCHAR(100),
    status ENUM('active', 'inactive', 'blacklisted') DEFAULT 'active',
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL,
    INDEX idx_tenant_type (tenant_type),
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_company (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Companies (formerly tbltrans_company)
CREATE TABLE companies (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    trade_name VARCHAR(255),
    business_type VARCHAR(100),
    industry VARCHAR(100),
    tax_id VARCHAR(100),
    email VARCHAR(255),
    phone VARCHAR(50),
    website VARCHAR(255),
    address_line1 VARCHAR(255),
    address_line2 VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100) DEFAULT 'Philippines',
    status ENUM('active', 'inactive') DEFAULT 'active',
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    INDEX idx_name (name),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### **4.2.3 Lease Management**

```sql
-- Inquiries (formerly tbltrans_inquiry)
CREATE TABLE inquiries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    inquiry_number VARCHAR(100) UNIQUE NOT NULL,
    inquirer_name VARCHAR(255) NOT NULL,
    inquirer_email VARCHAR(255),
    inquirer_phone VARCHAR(50),
    company_name VARCHAR(255),
    space_type VARCHAR(100),
    desired_area_sqm DECIMAL(10, 2),
    desired_move_in_date DATE,
    budget_min DECIMAL(15, 2),
    budget_max DECIMAL(15, 2),
    source VARCHAR(100),              -- walk-in, website, referral, etc.
    status ENUM('new', 'contacted', 'qualified', 'proposal_sent', 'won', 'lost') DEFAULT 'new',
    assigned_to BIGINT UNSIGNED,      -- user_id
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_status (status),
    INDEX idx_inquiry_number (inquiry_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reservations (formerly tbltrans_reservation)
CREATE TABLE reservations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    unit_id BIGINT UNSIGNED NOT NULL,
    tenant_id BIGINT UNSIGNED,
    reservation_number VARCHAR(100) UNIQUE NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_fee DECIMAL(15, 2) DEFAULT 0.00,
    reservation_paid DECIMAL(15, 2) DEFAULT 0.00,
    expiry_date DATE,
    status ENUM('active', 'converted', 'cancelled', 'expired') DEFAULT 'active',
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_unit (unit_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Lease Applications (formerly tbltrans_leasingapplication)
CREATE TABLE lease_applications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    tenant_id BIGINT UNSIGNED NOT NULL,
    application_number VARCHAR(100) UNIQUE NOT NULL,
    application_date DATE NOT NULL,
    desired_start_date DATE,
    desired_lease_term INT,                     -- months
    status ENUM('draft', 'submitted', 'under_review', 'approved', 'rejected', 'cancelled') DEFAULT 'draft',
    reviewed_by BIGINT UNSIGNED,
    reviewed_at TIMESTAMP NULL,
    rejection_reason TEXT,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_tenant (tenant_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Lease Application Units (many-to-many)
CREATE TABLE lease_application_unit (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lease_application_id BIGINT UNSIGNED NOT NULL,
    unit_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (lease_application_id) REFERENCES lease_applications(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE,
    UNIQUE KEY unique_application_unit (lease_application_id, unit_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Lease Contracts (formerly tblcontract)
CREATE TABLE lease_contracts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    tenant_id BIGINT UNSIGNED NOT NULL,
    contract_number VARCHAR(100) UNIQUE NOT NULL,
    lease_application_id BIGINT UNSIGNED,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    lease_term_months INT NOT NULL,
    billing_cycle ENUM('monthly', 'quarterly', 'semi_annual', 'annual') DEFAULT 'monthly',
    billing_day INT DEFAULT 1,                  -- Day of month for billing
    security_deposit DECIMAL(15, 2) DEFAULT 0.00,
    advance_rent_months INT DEFAULT 0,
    escalation_rate DECIMAL(5, 2) DEFAULT 0.00, -- Percentage
    escalation_frequency_months INT DEFAULT 12,
    payment_terms_days INT DEFAULT 15,          -- Payment due days after invoice
    status ENUM('draft', 'active', 'expiring', 'expired', 'terminated', 'renewed') DEFAULT 'draft',
    signed_date DATE,
    termination_date DATE,
    termination_reason TEXT,
    special_conditions TEXT,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (lease_application_id) REFERENCES lease_applications(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_tenant (tenant_id),
    INDEX idx_status (status),
    INDEX idx_dates (start_date, end_date),
    INDEX idx_contract_number (contract_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Lease Contract Units (many-to-many)
CREATE TABLE lease_contract_unit (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lease_contract_id BIGINT UNSIGNED NOT NULL,
    unit_id BIGINT UNSIGNED NOT NULL,
    monthly_rent DECIMAL(15, 2) NOT NULL,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (lease_contract_id) REFERENCES lease_contracts(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE,
    UNIQUE KEY unique_contract_unit (lease_contract_id, unit_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contract Charges (recurring and one-time)
CREATE TABLE contract_charges (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lease_contract_id BIGINT UNSIGNED NOT NULL,
    charge_type_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    is_recurring BOOLEAN DEFAULT true,
    frequency ENUM('one_time', 'monthly', 'quarterly', 'annual'),
    start_date DATE,
    end_date DATE,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (lease_contract_id) REFERENCES lease_contracts(id) ON DELETE CASCADE,
    FOREIGN KEY (charge_type_id) REFERENCES charge_types(id) ON DELETE CASCADE,
    INDEX idx_lease_contract (lease_contract_id),
    INDEX idx_charge_type (charge_type_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### **4.2.4 Billing & Invoicing**

```sql
-- Invoices (formerly dunn_tblsoaheader)
CREATE TABLE invoices (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    tenant_id BIGINT UNSIGNED NOT NULL,
    lease_contract_id BIGINT UNSIGNED,
    invoice_number VARCHAR(100) UNIQUE NOT NULL,
    invoice_date DATE NOT NULL,
    due_date DATE NOT NULL,
    billing_period_start DATE NOT NULL,
    billing_period_end DATE NOT NULL,
    subtotal DECIMAL(15, 2) DEFAULT 0.00,
    tax_amount DECIMAL(15, 2) DEFAULT 0.00,
    discount_amount DECIMAL(15, 2) DEFAULT 0.00,
    total_amount DECIMAL(15, 2) NOT NULL,
    paid_amount DECIMAL(15, 2) DEFAULT 0.00,
    balance DECIMAL(15, 2) NOT NULL,
    status ENUM('draft', 'issued', 'partially_paid', 'paid', 'overdue', 'cancelled') DEFAULT 'draft',
    issued_at TIMESTAMP NULL,
    cancelled_at TIMESTAMP NULL,
    cancellation_reason TEXT,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (lease_contract_id) REFERENCES lease_contracts(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_tenant (tenant_id),
    INDEX idx_contract (lease_contract_id),
    INDEX idx_status (status),
    INDEX idx_dates (invoice_date, due_date),
    INDEX idx_invoice_number (invoice_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Invoice Line Items (formerly dunn_tblsoadetails)
CREATE TABLE invoice_line_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT UNSIGNED NOT NULL,
    charge_type_id BIGINT UNSIGNED NOT NULL,
    unit_id BIGINT UNSIGNED,
    description VARCHAR(255) NOT NULL,
    quantity DECIMAL(10, 2) DEFAULT 1.00,
    unit_price DECIMAL(15, 2) NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    is_taxable BOOLEAN DEFAULT false,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (charge_type_id) REFERENCES charge_types(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE SET NULL,
    INDEX idx_invoice (invoice_id),
    INDEX idx_charge_type (charge_type_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Charge Types (formerly tblref_charges, tblref_charges_type)
CREATE TABLE charge_types (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    category ENUM('rent', 'utilities', 'association_dues', 'parking', 'penalty', 'deposit', 'other') NOT NULL,
    is_recurring BOOLEAN DEFAULT true,
    is_taxable BOOLEAN DEFAULT false,
    default_amount DECIMAL(15, 2) DEFAULT 0.00,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    INDEX idx_category (category),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Penalties (late payment penalties)
CREATE TABLE penalties (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice_id BIGINT UNSIGNED NOT NULL,
    penalty_date DATE NOT NULL,
    days_overdue INT NOT NULL,
    penalty_rate DECIMAL(5, 2) NOT NULL,          -- Percentage or flat
    penalty_amount DECIMAL(15, 2) NOT NULL,
    is_waived BOOLEAN DEFAULT false,
    waived_by BIGINT UNSIGNED,
    waived_at TIMESTAMP NULL,
    waiver_reason TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (waived_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### **4.2.5 Payments**

```sql
-- Payments (formerly tbl_tenantspayments)
CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    tenant_id BIGINT UNSIGNED NOT NULL,
    payment_number VARCHAR(100) UNIQUE NOT NULL,
    payment_date DATE NOT NULL,
    payment_method ENUM('cash', 'check', 'bank_transfer', 'credit_card', 'online', 'pdc') NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    applied_amount DECIMAL(15, 2) DEFAULT 0.00,   -- Amount applied to invoices
    unapplied_amount DECIMAL(15, 2) DEFAULT 0.00, -- Overpayment/credit
    reference_number VARCHAR(255),
    check_number VARCHAR(100),
    check_date DATE,
    bank_name VARCHAR(255),
    received_by BIGINT UNSIGNED,
    deposited_at TIMESTAMP NULL,
    status ENUM('pending', 'cleared', 'bounced', 'cancelled') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (received_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_tenant (tenant_id),
    INDEX idx_payment_date (payment_date),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payment Applications (link payments to invoices)
CREATE TABLE payment_applications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    payment_id BIGINT UNSIGNED NOT NULL,
    invoice_id BIGINT UNSIGNED NOT NULL,
    amount_applied DECIMAL(15, 2) NOT NULL,
    applied_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (payment_id) REFERENCES payments(id) ON DELETE CASCADE,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    INDEX idx_payment (payment_id),
    INDEX idx_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Receipts (official receipts for payments)
CREATE TABLE receipts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    payment_id BIGINT UNSIGNED NOT NULL,
    receipt_number VARCHAR(100) UNIQUE NOT NULL,
    receipt_date DATE NOT NULL,
    amount DECIMAL(15, 2) NOT NULL,
    issued_by BIGINT UNSIGNED,
    printed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (payment_id) REFERENCES payments(id) ON DELETE CASCADE,
    FOREIGN KEY (issued_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_payment (payment_id),
    INDEX idx_receipt_number (receipt_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### **4.2.6 Maintenance**

```sql
-- Maintenance Requests (tenant-submitted)
CREATE TABLE maintenance_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    unit_id BIGINT UNSIGNED,
    tenant_id BIGINT UNSIGNED,
    request_number VARCHAR(100) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100),
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    status ENUM('submitted', 'acknowledged', 'assigned', 'in_progress', 'completed', 'cancelled') DEFAULT 'submitted',
    requested_at TIMESTAMP NULL,
    acknowledged_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    cancelled_at TIMESTAMP NULL,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE SET NULL,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_unit (unit_id),
    INDEX idx_status (status),
    INDEX idx_priority (priority)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Work Orders (staff-created, can be from maintenance request)
CREATE TABLE work_orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_id BIGINT UNSIGNED NOT NULL,
    maintenance_request_id BIGINT UNSIGNED,
    work_order_number VARCHAR(100) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100),
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    type ENUM('preventive', 'corrective', 'emergency', 'project') DEFAULT 'corrective',
    assigned_to BIGINT UNSIGNED,                   -- user_id
    scheduled_date DATE,
    due_date DATE,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    status ENUM('draft', 'scheduled', 'in_progress', 'on_hold', 'completed', 'cancelled') DEFAULT 'draft',
    estimated_cost DECIMAL(15, 2) DEFAULT 0.00,
    actual_cost DECIMAL(15, 2) DEFAULT 0.00,
    is_billable BOOLEAN DEFAULT false,
    notes TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (maintenance_request_id) REFERENCES maintenance_requests(id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_property (property_id),
    INDEX idx_assigned (assigned_to),
    INDEX idx_status (status),
    INDEX idx_dates (scheduled_date, due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4.3 Foreign Key Strategy

**Cascading Deletes:**
- Child records deleted when parent is deleted
- Examples: invoice → line items, lease → charges

**Set NULL:**
- Reference cleared when parent deleted
- Examples: unit → building (if building deleted, unit remains)

**Restrict:**
- Prevent deletion if child records exist
- Examples: tenant with active leases cannot be deleted

---

## 5. Authentication & Authorization

### 5.1 Authentication (Laravel Breeze)

**Features:**
- Email/password login
- Registration (admin-only in production)
- Password reset
- Email verification
- Remember me
- Session management

**Implementation:**
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

### 5.2 Authorization (Spatie Laravel Permission)

**Role-Based Access Control (RBAC):**

```php
// Roles
- Super Admin (all permissions)
- Property Manager (property-scoped access)
- Accounting (billing, payments, reports)
- Leasing Agent (inquiries, applications, contracts)
- Maintenance Manager (work orders, maintenance)
- Front Desk (view-only + basic tasks)
- Tenant (portal access only)
```

**Permissions Structure:**

```php
// Format: {module}.{action}
properties.view
properties.create
properties.update
properties.delete

units.view
units.create
units.update
units.delete

tenants.view
tenants.create
tenants.update
tenants.delete

leases.view
leases.create
leases.update
leases.delete
leases.terminate

invoices.view
invoices.create
invoices.update
invoices.delete
invoices.cancel

payments.view
payments.create
payments.update
payments.delete

reports.view
reports.export

// Special permissions
billing.generate
billing.waive_penalty
payments.void
settings.manage
```

**Multi-Property Access:**

```php
// User has access to specific properties
User → Property (many-to-many)

// Query scoping
$units = Unit::whereIn('property_id', auth()->user()->property_ids)->get();
```

### 5.3 Policy-Based Authorization

```php
// app/Policies/LeaseContractPolicy.php
public function terminate(User $user, LeaseContract $lease)
{
    return $user->can('leases.terminate')
        && $user->hasAccessToProperty($lease->property_id);
}

// Usage in controller
$this->authorize('terminate', $leaseContract);
```

---

## 6. Frontend Architecture

### 6.1 UI Stack

**Core:**
- **Blade Templates** (server-side rendering)
- **Tailwind CSS** (utility-first styling)
- **Alpine.js** (lightweight reactivity)
- **Heroicons** (icon library)

**Layout Structure:**

```blade
<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PMS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar')

        <div class="lg:pl-64">
            <!-- Top Navigation -->
            @include('components.navbar')

            <!-- Page Content -->
            <main class="py-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
```

### 6.2 Component Library

**Reusable Blade Components:**

```blade
<!-- Button -->
<x-button type="submit" variant="primary">Save</x-button>

<!-- Form Input -->
<x-input name="property_name" label="Property Name" :value="old('property_name')" />

<!-- Select Dropdown -->
<x-select name="status" label="Status" :options="$statuses" />

<!-- Data Table -->
<x-table :headers="['Name', 'Email', 'Status']" :rows="$users" />

<!-- Modal -->
<x-modal name="confirm-delete" title="Confirm Deletion">
    <p>Are you sure?</p>
    <x-slot name="footer">
        <x-button @click="$dispatch('close')">Cancel</x-button>
        <x-button variant="danger">Delete</x-button>
    </x-slot>
</x-modal>
```

### 6.3 Alpine.js for Interactivity

```html
<!-- Dynamic form fields -->
<div x-data="{ open: false }">
    <button @click="open = ! open">Toggle</button>
    <div x-show="open" x-transition>Content</div>
</div>

<!-- Live search -->
<div x-data="{ search: '', items: [] }">
    <input x-model="search" @input="fetchResults()">
    <template x-for="item in items">
        <div x-text="item.name"></div>
    </template>
</div>
```

### 6.4 Responsive Design

**Tailwind Breakpoints:**
- `sm:` 640px
- `md:` 768px
- `lg:` 1024px
- `xl:` 1280px
- `2xl:` 1536px

**Mobile-First Approach:**
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Responsive grid -->
</div>
```

---

## 7. Backend Architecture

### 7.1 Request Lifecycle

```
Request → Middleware → Controller → Action/Service → Model → Database
                                        ↓
Response ← View/JSON ← Resource ← Return Value
```

### 7.2 Controller Pattern

**Thin Controllers:**

```php
// app/Http/Controllers/Lease/LeaseContractController.php
class LeaseContractController extends Controller
{
    public function __construct(
        private LeaseService $leaseService
    ) {}

    public function store(StoreLeaseContractRequest $request)
    {
        $lease = $this->leaseService->createLease(
            LeaseContractData::fromRequest($request)
        );

        return redirect()
            ->route('leases.show', $lease)
            ->with('success', 'Lease contract created successfully.');
    }
}
```

### 7.3 Service Layer

**Business Logic in Services:**

```php
// app/Services/Lease/LeaseService.php
class LeaseService
{
    public function createLease(LeaseContractData $data): LeaseContract
    {
        return DB::transaction(function () use ($data) {
            // Create lease contract
            $lease = LeaseContract::create($data->toArray());

            // Attach units
            $lease->units()->attach($data->units);

            // Create charges
            foreach ($data->charges as $charge) {
                $lease->charges()->create($charge);
            }

            // Update unit status
            Unit::whereIn('id', $data->units)
                ->update(['status' => UnitStatus::Occupied]);

            // Fire event
            event(new LeaseCreated($lease));

            return $lease;
        });
    }
}
```

### 7.4 Action Pattern

**Single-Purpose Actions:**

```php
// app/Actions/Billing/GenerateMonthlyInvoicesAction.php
class GenerateMonthlyInvoicesAction
{
    public function execute(Carbon $billingDate): Collection
    {
        $activeLeases = LeaseContract::active()
            ->whereBillingDay($billingDate->day)
            ->with(['tenant', 'units', 'charges'])
            ->get();

        return $activeLeases->map(function ($lease) use ($billingDate) {
            return $this->generateInvoiceForLease($lease, $billingDate);
        });
    }

    private function generateInvoiceForLease(LeaseContract $lease, Carbon $date): Invoice
    {
        // Invoice generation logic
    }
}
```

### 7.5 Repository Pattern (Optional)

**Data Access Abstraction:**

```php
// app/Repositories/LeaseContractRepository.php
class LeaseContractRepository
{
    public function findExpiringContracts(int $days): Collection
    {
        return LeaseContract::active()
            ->whereBetween('end_date', [now(), now()->addDays($days)])
            ->with(['tenant', 'property'])
            ->get();
    }
}
```

---

## 8. Module Design

### 8.1 Billing Engine

**Monthly Billing Process:**

```php
// Job: GenerateMonthlyBillingJob
1. Find all active leases due for billing
2. For each lease:
   a. Calculate base rent
   b. Add recurring charges
   c. Add utility charges (meter readings)
   d. Apply proration (if mid-month)
   e. Apply escalations
   f. Create invoice with line items
3. Calculate penalties for overdue invoices
4. Send invoice notifications
```

**Proration Logic:**

```php
// If tenant moves in on day 15 of 30-day month
$daysInMonth = 30;
$daysOccupied = 16; // From day 15 to day 30
$monthlyRent = 30000;
$proratedRent = ($monthlyRent / $daysInMonth) * $daysOccupied; // 16,000
```

**Penalty Calculation:**

```php
// 2% penalty per month overdue
$daysOverdue = $invoice->due_date->diffInDays(now());
$monthsOverdue = ceil($daysOverdue / 30);
$penaltyRate = 0.02; // 2%
$penaltyAmount = $invoice->balance * $penaltyRate * $monthsOverdue;
```

### 8.2 Payment Processing

**Payment Application:**

```php
// Apply payment to oldest invoices first (FIFO)
1. Receive payment
2. Find unpaid invoices for tenant (oldest first)
3. Apply payment amount to each invoice until exhausted
4. Update invoice balances and statuses
5. Track unapplied amount (overpayment)
6. Generate receipt
```

### 8.3 Lease Lifecycle Management

**State Machine:**

```php
Draft → Active → Expiring Soon (60 days) → Expired/Renewed/Terminated
```

**Auto-Status Updates:**

```php
// Command: UpdateLeaseStatusesCommand (run daily)
- Set 'expiring' status for leases ending in 60 days
- Set 'expired' status for leases past end date
- Notify property managers
```

---

## 9. Security Strategy

### 9.1 Authentication Security

✅ **Implementations:**
- Bcrypt password hashing (Laravel default)
- Rate limiting on login attempts
- CSRF protection on all forms
- Session fixation protection
- Secure session cookies (httpOnly, sameSite)

### 9.2 Authorization Security

✅ **Implementations:**
- Policy-based authorization
- Multi-property scope enforcement
- Role-based access control
- Audit logging (Spatie Activity Log)

### 9.3 Input Validation

✅ **Implementations:**
- Form Request validation
- Database-level constraints
- XSS protection (Blade auto-escaping)
- SQL injection protection (Query Builder/Eloquent)

### 9.4 Data Protection

✅ **Implementations:**
- Encrypted sensitive fields
- Soft deletes (data recovery)
- Database backups (daily)
- Audit trail for critical operations

---

## 10. Performance Optimization

### 10.1 Database Optimization

```php
// Eager loading (prevent N+1)
$leases = LeaseContract::with(['tenant', 'units', 'property'])->get();

// Query caching
Cache::remember('active_leases', 3600, fn() => LeaseContract::active()->get());

// Chunking large datasets
Invoice::chunk(1000, function ($invoices) {
    // Process in batches
});
```

### 10.2 Caching Strategy

```php
// Cache layers
- Route caching
- Config caching
- View caching
- Query result caching (Redis)
- Full-page caching (for reports)
```

### 10.3 Queue System

```php
// Background jobs
- GenerateMonthlyBillingJob
- SendInvoiceEmailJob
- GenerateReportJob
- ProcessBulkPaymentJob
```

---

## 11. Testing Strategy

### 11.1 Test Types

**Feature Tests:**
```php
// tests/Feature/Lease/CreateLeaseContractTest.php
test('can create lease contract', function () {
    $tenant = Tenant::factory()->create();
    $unit = Unit::factory()->create();

    $response = $this->post('/leases', [
        'tenant_id' => $tenant->id,
        'unit_ids' => [$unit->id],
        'start_date' => '2025-01-01',
        'end_date' => '2025-12-31',
        'monthly_rent' => 30000,
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('lease_contracts', [
        'tenant_id' => $tenant->id,
    ]);
});
```

**Unit Tests:**
```php
// tests/Unit/Services/ProrationServiceTest.php
test('calculates prorated rent correctly', function () {
    $service = new ProrationService();
    $prorated = $service->calculate(30000, '2025-01-15', '2025-01-31');
    expect($prorated)->toBe(16000.0);
});
```

---

## 12. Deployment Architecture

### 12.1 Environment Setup

**Local Development:**
- Laravel Valet / Laravel Herd
- MariaDB via Docker
- Redis via Docker

**Staging:**
- Docker containers
- Continuous deployment (GitHub Actions)

**Production:**
- Load balancer
- Multiple app servers
- Dedicated database server (MariaDB)
- Redis cluster (cache + queues)
- CDN for assets

---

## CONCLUSION

This architecture provides a **modern, scalable, secure, and maintainable** foundation for the Property Management System. The design follows Laravel best practices while implementing clean architecture principles.

**Key Benefits:**
- ✅ **Secure:** Modern auth, RBAC, input validation
- ✅ **Fast:** Optimized queries, caching, queues
- ✅ **Testable:** Dependency injection, service layer
- ✅ **Maintainable:** Clean code, separation of concerns
- ✅ **Scalable:** Queue system, caching, modular design

**Next Steps:**
1. Initialize Laravel 11 project
2. Set up authentication with Breeze
3. Create database migrations
4. Implement core modules iteratively

---

**Document Version:** 1.0
**Author:** Laravel Migration Team
**Date:** November 17, 2025
