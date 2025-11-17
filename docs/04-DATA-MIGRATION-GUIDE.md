# Data Migration Guide

**From:** Legacy PHP4 PMS (gates_smm3 database)
**To:** Laravel 11 PMS
**Date:** November 17, 2025
**Version:** 1.0

---

## Table of Contents

1. [Overview](#overview)
2. [Prerequisites](#prerequisites)
3. [Database Setup](#database-setup)
4. [Migration Process](#migration-process)
5. [Table Mappings](#table-mappings)
6. [Column Mappings](#column-mappings)
7. [Enum Value Mappings](#enum-value-mappings)
8. [Known Issues](#known-issues)
9. [Rollback Procedures](#rollback-procedures)
10. [Verification Steps](#verification-steps)
11. [Troubleshooting](#troubleshooting)

---

## Overview

This guide provides comprehensive instructions for migrating data from the legacy PHP4 Property Management System to the new Laravel 11 application.

**Migration Scope:**
- 312 legacy tables → 20+ normalized Laravel tables
- Hungarian notation → Laravel conventions
- Mixed case → snake_case naming
- latin1 charset → utf8mb4
- MD5 passwords → bcrypt

**Estimated Time:** 2-6 hours (depending on data volume)

---

## Prerequisites

### 1. Database Access

Ensure you have access credentials for both databases:

**Legacy Database:**
- Host: [legacy server]
- Database: `gates_smm3`
- User: [with READ access]
- Password: [secure password]

**New Database:**
- Host: [new server]
- Database: `pms_laravel`
- User: [with READ/WRITE access]
- Password: [secure password]

### 2. Environment Configuration

Add to your `.env` file:

```env
# Legacy Database Connection
LEGACY_DB_HOST=127.0.0.1
LEGACY_DB_PORT=3306
LEGACY_DB_DATABASE=gates_smm3
LEGACY_DB_USERNAME=root
LEGACY_DB_PASSWORD=your_password_here

# New Database Connection (already configured)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pms_laravel
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 3. Register Legacy Connection

Add to `config/database.php`:

```php
'connections' => [
    // ... existing connections ...

    'legacy' => config('legacy.connection'),
],
```

### 4. System Requirements

- PHP 8.2+
- MySQL 8.0+
- Minimum 2GB RAM
- 10GB free disk space
- Stable network connection

### 5. Backup

**CRITICAL:** Always backup both databases before migration!

```bash
# Backup legacy database
mysqldump -u root -p gates_smm3 > legacy_backup_$(date +%Y%m%d).sql

# Backup new database (if has existing data)
mysqldump -u root -p pms_laravel > new_backup_$(date +%Y%m%d).sql
```

---

## Database Setup

### Step 1: Test Connections

```bash
php artisan tinker
>>> DB::connection()->getPdo();  // Test new DB
>>> DB::connection('legacy')->getPdo();  // Test legacy DB
```

If connections fail, verify credentials and network access.

### Step 2: Run Fresh Migrations

**WARNING:** This will delete all existing data in the new database!

```bash
php artisan migrate:fresh
```

Or if you want to preserve existing data:

```bash
php artisan migrate
```

---

## Migration Process

### Option 1: Full Migration (Recommended)

Migrate all tables in the correct order:

```bash
php artisan pms:migrate-legacy-data
```

You'll see a migration plan. Confirm to proceed.

**With options:**

```bash
# Clean existing data before migration
php artisan pms:migrate-legacy-data --clean

# Skip confirmation prompts
php artisan pms:migrate-legacy-data --force

# Clean + Force
php artisan pms:migrate-legacy-data --clean --force
```

### Option 2: Dry Run

Preview what will be migrated without actually migrating:

```bash
php artisan pms:migrate-legacy-data --dry-run
```

### Option 3: Migrate Specific Table

Migrate only one table:

```bash
php artisan pms:migrate-legacy-data --table=properties
php artisan pms:migrate-legacy-data --table=tenants
php artisan pms:migrate-legacy-data --table=lease_contracts
```

**Available tables:**
- properties
- buildings
- floors
- units
- companies
- tenants
- inquiries
- reservations
- lease_applications
- lease_contracts
- invoices
- payments
- maintenance_requests
- work_orders

### Migration Order

The system migrates tables in this order to maintain referential integrity:

1. **Core Entities**
   - Properties
   - Buildings
   - Floors
   - Units

2. **Business Entities**
   - Companies
   - Tenants

3. **Leasing Workflow**
   - Inquiries
   - Reservations
   - Lease Applications
   - Lease Contracts (with unit assignments)

4. **Financial**
   - Invoices (with line items)
   - Payments (with applications)

5. **Operations**
   - Maintenance Requests
   - Work Orders

6. **Data Cleanup**
   - Update invoice statuses
   - Update unit statuses
   - Validate relationships

---

## Table Mappings

| New Table | Legacy Table | Records | Notes |
|-----------|--------------|---------|-------|
| properties | tblref_mall | ~10 | Property/Mall master data |
| buildings | tblref_bldg | ~20 | Buildings per property |
| floors | tblref_floorsetup | ~100 | Floor configuration |
| units | tblref_unit | ~500+ | Unit/Space inventory |
| companies | tbltrans_company | ~200 | Corporate entities |
| tenants | tbltrans_tenants | ~300+ | Individual & Corporate tenants |
| inquiries | tbltrans_inquiry | ~1000+ | Lead inquiries |
| reservations | tbltrans_reservation | ~500 | Unit reservations |
| lease_applications | tbltrans_leasingapplication | ~400 | Leasing applications |
| lease_contracts | tblcontract | ~300+ | Active & historical contracts |
| invoices | dunn_tblsoaheader | ~5000+ | Statement of Accounts |
| invoice_line_items | dunn_tblsoadetails | ~20000+ | SOA line items |
| payments | tbl_tenantspayments | ~3000+ | Payment records |
| payment_applications | tbltrans_paymentapplogs | ~10000+ | Payment allocations |
| maintenance_requests | tblcomplaints | ~1000+ | Tenant complaints |
| work_orders | tblmaintenance_workorder | ~800+ | Maintenance work orders |

---

## Column Mappings

### Properties

| New Column | Legacy Column(s) | Transformation |
|------------|------------------|----------------|
| id | id | Direct |
| code | MallCode, PropertyCode | Trim, nullable |
| name | MallName, PropertyName | Trim |
| type | PropertyType, Type | Enum conversion |
| address_line1 | Address, Address1 | Trim |
| address_line2 | Address2 | Trim, nullable |
| city | City | Trim |
| state | Province, State | Trim |
| postal_code | ZipCode, PostalCode | Trim |
| country | Country | Default: 'Philippines' |
| phone | ContactNumber, Phone | Trim |
| email | Email | Lowercase, validate |
| tax_id | TIN, TaxID | Trim |
| status | Status | Map to active/inactive |

### Units

| New Column | Legacy Column(s) | Transformation |
|------------|------------------|----------------|
| id | id | Direct |
| property_id | PropertyID, MallID | FK lookup |
| building_id | BuildingID, BldgID | FK lookup |
| floor_id | FloorID | FK lookup |
| unit_code | UnitCode, Code | Trim |
| unit_number | UnitNumber, Number | Trim |
| type | UnitType, Type | Enum: commercial, office, residential, parking, storage, kiosk |
| classification | Classification, Category | Trim |
| area_sqm | FloorArea, SQM | Decimal(10,2) |
| bedrooms | Bedrooms, NoOfBedrooms | Integer |
| bathrooms | Bathrooms, NoOfBathrooms | Integer |
| status | Status | Enum: vacant, occupied, reserved, maintenance, unavailable |
| base_rent | MonthlyRent, BaseRent, Rent | Decimal(12,2) |
| association_dues | AssociationDues, Dues | Decimal(12,2) |

### Tenants

**Individual Tenants:**

| New Column | Legacy Column(s) | Transformation |
|------------|------------------|----------------|
| tenant_type | TenantType | 'individual' |
| first_name | FirstName, FName | Trim |
| last_name | LastName, LName | Trim |
| email | Email, ContactEmail | Lowercase, validate |
| phone | Phone, ContactNumber | Trim |
| mobile | Mobile, CellNumber, MobileNumber | Trim |

**Corporate Tenants:**

| New Column | Legacy Column(s) | Transformation |
|------------|------------------|----------------|
| tenant_type | TenantType | 'corporate' |
| company_id | CompanyID | FK lookup |
| first_name | ContactFirstName, ContactPerson | Contact person name |
| last_name | ContactLastName | Contact person name |
| email | ContactEmail | Lowercase, validate |

### Lease Contracts

| New Column | Legacy Column(s) | Transformation |
|------------|------------------|----------------|
| property_id | PropertyID, MallID | FK lookup |
| tenant_id | TenantID | FK lookup |
| contract_number | ContractNo, ContractNumber | Trim |
| contract_date | ContractDate, DateSigned | Date parsing |
| start_date | StartDate, LeaseStart | Date parsing |
| end_date | EndDate, LeaseEnd | Date parsing |
| lease_term_months | LeaseTermMonths, Term, LeaseTerm | Integer |
| security_deposit | SecurityDeposit, Deposit | Decimal(12,2) |
| advance_rent_months | AdvanceRentMonths, Advance | Integer |
| billing_cycle | BillingCycle, BillingFrequency | Enum: monthly, quarterly, annually |
| escalation_rate | EscalationRate, Escalation | Decimal(5,2) percentage |
| status | Status | Enum: draft, active, expired, terminated, renewed |

### Invoices

| New Column | Legacy Column(s) | Transformation |
|------------|------------------|----------------|
| invoice_number | InvoiceNo, SOANo, InvoiceNumber | Trim |
| invoice_date | InvoiceDate, SOADate, BillingDate | Date parsing |
| due_date | DueDate, PaymentDueDate | Date parsing |
| period_start | PeriodStart, BillingPeriodStart | Date parsing |
| period_end | PeriodEnd, BillingPeriodEnd | Date parsing |
| subtotal | Subtotal, Amount | Decimal(12,2) |
| tax_amount | TaxAmount, Tax | Decimal(12,2) |
| total_amount | TotalAmount, Total | Decimal(12,2) |
| amount_paid | AmountPaid, Paid | Decimal(12,2) |
| status | Status | Auto-calculate from amounts + enum mapping |

### Payments

| New Column | Legacy Column(s) | Transformation |
|------------|------------------|----------------|
| payment_number | PaymentNo, ReceiptNo | Trim |
| payment_date | PaymentDate, DatePaid | Date parsing |
| payment_method | PaymentMethod, PaymentType | Enum: cash, check, bank_transfer, credit_card, online |
| amount | Amount, PaymentAmount | Decimal(12,2) |
| reference_number | ReferenceNo, ReferenceNumber, TransactionRef | Trim |
| check_number | CheckNo, CheckNumber, ChequeNumber | Trim |
| check_date | CheckDate, ChequeDate | Date parsing |
| bank_name | BankName, Bank | Trim |
| status | Status | Enum: pending, cleared, bounced, void |

---

## Enum Value Mappings

### Property Type

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| mall, Mall, shopping mall | mall | Shopping Mall |
| office, Office, office building | office_building | Office Building |
| residential, Residential | residential | Residential Complex |
| mixed use, Mixed Use | mixed_use | Mixed Use |
| industrial, Industrial | industrial | Industrial Park |

### Unit Type

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| commercial, Commercial, retail, shop | commercial | Commercial |
| office, Office | office | Office |
| residential, Residential, condo, apartment | residential | Residential |
| parking, Parking | parking | Parking |
| storage, Storage, warehouse | storage | Storage |
| kiosk, Kiosk | kiosk | Kiosk |

### Unit Status

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| vacant, Vacant, available, Available | vacant | Vacant |
| occupied, Occupied, leased, Leased | occupied | Occupied |
| reserved, Reserved | reserved | Reserved |
| maintenance, Maintenance, under maintenance | maintenance | Under Maintenance |
| unavailable, Unavailable, inactive | unavailable | Unavailable |

### Tenant Type

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| individual, Individual, personal | individual | Individual |
| corporate, Corporate, company, business | corporate | Corporate |

### Tenant Status

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| active, Active, 1 | active | Active |
| inactive, Inactive, 0 | inactive | Inactive |
| blacklisted, Blacklisted, blacklist, banned | blacklisted | Blacklisted |

### Lease Status

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| draft, Draft, pending | draft | Draft |
| active, Active, ongoing, current | active | Active |
| expired, Expired | expired | Expired |
| terminated, Terminated, cancelled | terminated | Terminated |
| renewed, Renewed | renewed | Renewed |

### Invoice Status

| Legacy Value | New Enum Value | Notes |
|--------------|----------------|-------|
| draft, Draft | draft | Not finalized |
| pending, Pending, sent, unpaid | sent | Sent to tenant |
| partial, partially paid | partially_paid | Auto-detected from amount_paid |
| paid, Paid | paid | Auto-detected (amount_paid >= total) |
| overdue, Overdue | overdue | Past due date |
| void, Void, cancelled | void | Cancelled |

### Payment Method

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| cash, Cash | cash | Cash |
| check, Check, cheque | check | Check |
| bank transfer, transfer, wire | bank_transfer | Bank Transfer |
| credit card, card | credit_card | Credit Card |
| online, paypal | online | Online Payment |

### Payment Status

| Legacy Value | New Enum Value | Label |
|--------------|----------------|-------|
| pending, Pending | pending | Pending |
| cleared, Cleared, completed, approved | cleared | Cleared |
| bounced, Bounced, returned, dishonored | bounced | Bounced |
| void, Void, cancelled | void | Void |

---

## Known Issues

### 1. Character Encoding

**Issue:** Legacy database uses `latin1`, new database uses `utf8mb4`.

**Impact:** Special characters may not display correctly.

**Solution:** The migration service handles charset conversion automatically. Review migrated data for special characters.

### 2. Invalid Dates

**Issue:** Legacy database has '0000-00-00' dates.

**Impact:** These dates cannot be migrated to MySQL strict mode.

**Solution:** Invalid dates are converted to `NULL`.

### 3. Missing Foreign Keys

**Issue:** Legacy database has no foreign key constraints.

**Impact:** Some records may reference non-existent parent records.

**Solution:**
- Migration validates FK relationships
- Orphaned records are logged and skipped
- Check migration log for orphaned records

### 4. Duplicate Entries

**Issue:** Some legacy tables have duplicate records.

**Impact:** Unique constraints may fail.

**Solution:**
- First occurrence is migrated
- Duplicates are logged and skipped
- Manual review required

### 5. MD5 Passwords

**Issue:** Legacy system uses MD5 password hashing.

**Impact:** Cannot migrate passwords securely.

**Solution:**
- Users are created with default password: `ChangeMe123!`
- Users must reset password on first login
- Consider sending password reset emails

### 6. Decimal Precision

**Issue:** Legacy uses `float(20,2)`, can lose precision.

**Impact:** Very large amounts may differ slightly.

**Solution:**
- New system uses `decimal(12,2)` for accuracy
- Amounts are rounded to 2 decimal places
- Review financial totals after migration

### 7. Empty Strings

**Issue:** Legacy has many empty strings ('') instead of NULL.

**Impact:** Data inconsistency.

**Solution:**
- Migration converts empty strings to NULL (configurable)
- Check `config/legacy.php` → `null_empty_strings`

---

## Rollback Procedures

### Quick Rollback

If migration fails or data is incorrect:

```bash
# 1. Restore new database from backup
mysql -u root -p pms_laravel < new_backup_YYYYMMDD.sql

# 2. Run fresh migrations
php artisan migrate:fresh

# 3. Fix issues and retry
php artisan pms:migrate-legacy-data
```

### Selective Rollback

To rollback specific tables:

```bash
# 1. Truncate specific table
php artisan tinker
>>> DB::table('tenants')->truncate();

# 2. Re-migrate that table
php artisan pms:migrate-legacy-data --table=tenants
```

### Complete Rollback

To completely undo migration:

```bash
# 1. Drop all tables
php artisan migrate:fresh

# 2. Start over
php artisan migrate
php artisan pms:migrate-legacy-data
```

---

## Verification Steps

After migration, verify data integrity:

### 1. Record Counts

```sql
-- Compare record counts
SELECT 'Properties' as Entity, COUNT(*) as Count FROM properties
UNION ALL
SELECT 'Units', COUNT(*) FROM units
UNION ALL
SELECT 'Tenants', COUNT(*) FROM tenants
UNION ALL
SELECT 'Lease Contracts', COUNT(*) FROM lease_contracts
UNION ALL
SELECT 'Invoices', COUNT(*) FROM invoices
UNION ALL
SELECT 'Payments', COUNT(*) FROM payments;
```

Compare with legacy database counts.

### 2. Financial Totals

```sql
-- Verify invoice totals
SELECT
    COUNT(*) as invoice_count,
    SUM(total_amount) as total_invoiced,
    SUM(amount_paid) as total_paid,
    SUM(total_amount - amount_paid) as total_outstanding
FROM invoices;

-- Verify payment totals
SELECT
    COUNT(*) as payment_count,
    SUM(amount) as total_payments
FROM payments
WHERE status = 'cleared';
```

### 3. Relationship Integrity

```sql
-- Check orphaned units (no property)
SELECT COUNT(*) FROM units WHERE property_id IS NULL;

-- Check orphaned tenants (corporate but no company)
SELECT COUNT(*) FROM tenants
WHERE tenant_type = 'corporate' AND company_id IS NULL;

-- Check lease contracts without units
SELECT COUNT(*) FROM lease_contracts lc
LEFT JOIN lease_contract_unit lcu ON lc.id = lcu.lease_contract_id
WHERE lcu.id IS NULL;
```

Should all return 0.

### 4. Data Quality

```sql
-- Check for invalid emails
SELECT COUNT(*) FROM tenants
WHERE email IS NOT NULL AND email NOT LIKE '%@%';

-- Check for future dates
SELECT COUNT(*) FROM invoices WHERE invoice_date > NOW();

-- Check for negative amounts
SELECT COUNT(*) FROM payments WHERE amount < 0;
```

### 5. Enum Values

```sql
-- Verify unit statuses
SELECT status, COUNT(*) FROM units GROUP BY status;

-- Verify tenant types
SELECT tenant_type, COUNT(*) FROM tenants GROUP BY tenant_type;

-- Verify lease statuses
SELECT status, COUNT(*) FROM lease_contracts GROUP BY status;
```

Ensure all values are valid enums.

### 6. Business Logic

```bash
# Test in Laravel
php artisan tinker

# Test property with units
>>> $property = Property::with('units')->first();
>>> $property->units->count();

# Test tenant with contracts
>>> $tenant = Tenant::with('leaseContracts')->first();
>>> $tenant->leaseContracts;

# Test invoice with line items
>>> $invoice = Invoice::with('lineItems')->first();
>>> $invoice->lineItems->sum('total');
```

---

## Troubleshooting

### Connection Errors

**Error:** `SQLSTATE[HY000] [2002] Connection refused`

**Solution:**
- Verify database host and port
- Check if MySQL is running
- Verify firewall rules
- Test with `mysql` CLI

### Foreign Key Errors

**Error:** `Cannot add or update a child row: a foreign key constraint fails`

**Solution:**
- Migration order is wrong (shouldn't happen with our service)
- Parent record doesn't exist
- Check migration log for details

### Memory Errors

**Error:** `Allowed memory size exhausted`

**Solution:**
- Reduce chunk size in `config/legacy.php`
- Increase PHP memory limit in `php.ini`
- Migrate tables individually

### Timeout Errors

**Error:** `Maximum execution time exceeded`

**Solution:**
- Increase `max_execution_time` in `php.ini`
- Run migration via CLI (not web)
- Migrate tables individually

### Encoding Issues

**Error:** Characters display as `�` or `?`

**Solution:**
- Verify legacy database charset
- Check connection charset
- May need manual data cleaning

### Duplicate Key Errors

**Error:** `Duplicate entry 'X' for key 'PRIMARY'`

**Solution:**
- Legacy data has ID conflicts
- Consider using `--clean` to start fresh
- Or manually fix duplicate IDs

---

## Support

For issues or questions:

1. Check migration log: `storage/logs/migration.log`
2. Review error report in command output
3. Contact: [your-support-email]
4. Documentation: `docs/01-LEGACY-SYSTEM-ANALYSIS.md`

---

## Appendix

### Migration Log Sample

```
[2025-11-17 10:00:00] Migration started
[2025-11-17 10:00:05] Migrating properties... 10 records
[2025-11-17 10:00:06] Properties migration completed: 10 success, 0 failed
[2025-11-17 10:00:06] Migrating units... 532 records
[2025-11-17 10:00:15] Units migration completed: 530 success, 2 failed
[2025-11-17 10:00:15] Error in units (ID: 125): property_id not found
[2025-11-17 10:00:15] Error in units (ID: 267): property_id not found
...
```

### Performance Benchmarks

Typical migration times (1000 records):

| Table | Time | Throughput |
|-------|------|------------|
| Properties | 2s | 500 records/s |
| Units | 15s | 67 records/s |
| Tenants | 10s | 100 records/s |
| Contracts | 20s | 50 records/s |
| Invoices | 60s | 17 records/s |
| Payments | 30s | 33 records/s |

Total migration time for typical dataset: **2-4 hours**

---

**Document Version:** 1.0
**Last Updated:** November 17, 2025
**Author:** Laravel Migration Team
