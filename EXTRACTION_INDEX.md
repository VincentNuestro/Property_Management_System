# Database Schema Extraction - Property Management System

## Extraction Summary

**Source File:** gates_smm March 3, 2020.sql
**Database:** gates_smm3
**Total Tables:** 312
**Extraction Date:** October 31, 2025
**Status:** Complete - All schemas extracted without data

## Generated Files

### 1. TABLE_STRUCTURES.sql (224 KB)
Complete SQL file containing CREATE TABLE statements for all 312 tables.

**Contents:**
- Numbered table list (1-312) at the top for quick reference
- Full CREATE TABLE statements for each table
- All column definitions with data types
- Primary key constraints
- Index definitions (KEY constraints)
- Default values and NULL constraints
- Engine type and charset information
- No INSERT statements or data

**Usage:**
- Import directly into MySQL/MariaDB
- Reference for Laravel migration creation
- Database documentation

### 2. TABLE_SUMMARY.txt
Human-readable summary document with:
- Complete numbered table list (1-312)
- Tables organized by category/module
- Notes for Laravel migration conversion
- Key information about schema structure

### 3. EXTRACTION_INDEX.md
This file - Quick reference guide for all extracted content

## Database Modules and Table Groups

### System Configuration (3 tables)
- tblsys_connsetup
- tblsys_setup
- tblsys_setup2

### User Management (3 tables)
- tbluser
- tblgroups
- tblref_usergroupaccess
- tblref_groupaccess
- tblref_groupaccess2

### Reference/Master Data (90+ tables)
All tables prefixed with `tblref_` and `ref_`:
- Employee data, positions, departments
- Building and unit information
- Floor setup and layouts
- Financial codes and rates
- Classification and type lookups
- Location and geography data
- Equipment and asset definitions

### Transaction Management (70+ tables)
All tables prefixed with `tbltrans_`:
- Company records and contact information
- Tenant management and applications
- Inquiry tracking
- Leasing applications and contracts
- Proposals and counter-proposals
- Rental renewals and escalations
- Payment tracking and records
- Memos and remarks
- Events and activities
- Leads and leads management

### Event Management (10 tables)
- event_header
- event_facilities
- event_manpower
- event_organizer
- event_paraphernalia
- event_personnel
- event_promotional
- event_requirements
- event_soundsystem
- event_attachments
- event_dayactivity

### Sales and Point-of-Sale (24 tables)
Separate sets for different locations/divisions:
- db_* (Database set)
- fdb_* (Food/Beverage set)
- sdb_* (Store/Shop set)

Tables include:
- Sales transactions
- Discounts
- Payment types and methods
- Voids and refunds
- Hourly sales data
- Sales by merchant/day

### Financial and Billing (15+ tables)
- dunn_* (Dunning/SOA related tables)
- tbl_charges_detail
- tblref_charges
- tblref_charges_type
- tblref_penalty
- tblref_paymentsched
- tblref_billperiod
- tblref_billprofile
- tblref_operationalcharges
- tbltrans_pdc
- tbltrans_processedbill
- tbltrans_processedsoa

### Maintenance Management (20+ tables)
- tblmaintenance_* (Work orders, equipment, violations)
- tblref_maintenancetasksetup
- tblasset_maintenance_d/h
- tblref_msmaintenance_d/h

### Property/Unit Management (30+ tables)
- tblref_unit* (Unit details, coordinates, amenities)
- tblref_bldg (Building information)
- tblref_floorsetup (Floor layouts)
- tblref_wing (Building wings)
- tblref_location (Locations)
- tbltrans_tenants (Tenant records)

### Directory/Map System (9 tables)
- mall_directory_categories
- mall_directory_floors
- mall_directory_shops
- mall_directory_shops_coordinates
- mall_directory_other_coordinates
- mall_directory_others
- mall_directory_route
- mall_directory_recordid
- mall_directory_top_searches

### Android Mobile App (9 tables)
- pmls_android_user
- pmls_android_location_task
- pmls_android_reffield
- pmls_android_reflocation
- pmls_android_refroom
- pmls_android_reftask
- pmls_android_worker_task
- pmls_android_worker_task_history

### Accreditation System (3 tables)
- tblaccreditation
- tblaccreditationdocs
- tblaccreditationlogs

### Chat/Communication (4 tables)
- tblchat_header
- tblchat_log
- tblchat_record
- tbltenant_chat
- tbltenant_chat_header

### Complaint Management (2 tables)
- tblcomplaints
- tblcomplaintscode

### Reporting and Logging (8+ tables)
- tbllog_sheet
- tblloggedmachine
- tbllogs_per_trans
- tbllogs_zaputility
- tblref_dbupdatelogs
- tblxreadinglogs
- tblzreadinglogs
- tblunit_statuslogs
- tblref_consologs

## Column Data Types Summary

### Common Data Types Used
- **int(11)** - Standard integer IDs and counts
- **bigint(20)** - Large ID numbers
- **varchar(n)** - Text fields (various lengths)
- **text** - Long text content
- **date** - Date values
- **datetime** - Date and time values
- **time** - Time values only
- **float(20,2)** - Financial amounts (20 total digits, 2 decimal places)
- **decimal(n,m)** - Precise decimal values for accounting
- **tinyint** - Boolean and small integer values (0/1)
- **double** - Large decimal numbers

### Key Constraints
- **PRIMARY KEY** - Unique identifier for each table
- **KEY/INDEX** - Performance indexes on commonly queried columns
- **AUTO_INCREMENT** - Auto-incrementing ID fields

## Database Characteristics

**Engine:** InnoDB (supports transactions and foreign keys)
**Charset:** latin1 (legacy - consider utf8mb4 for new Laravel project)
**Version:** MySQL 5.6.17

## Notes for Laravel Migration

### Key Considerations:
1. **Naming Conventions:** Table names are not following Laravel snake_case convention (many are camelCase)
2. **Column Naming:** Column names use Hungarian notation (f = float, n = number, vc = varchar, etc.)
3. **Charset Migration:** Consider migrating from latin1 to utf8mb4 for better character support
4. **Timestamps:** Some tables use `timestamp` fields which should map to Laravel timestamps
5. **IDs:** Most tables use `auto_increment` which maps to `$table->increments()` or `$table->id()`

### Migration Strategy:
1. Use TABLE_STRUCTURES.sql as reference
2. Create individual migration files per table
3. Consider grouping related tables by module
4. Add Laravel-specific fields (created_at, updated_at, soft_deletes)
5. Define relationships and foreign keys in migrations or models

## Sample Table Structures

See TABLE_STRUCTURES.sql for complete definitions. Sample structures included for:
- categories (simple lookup table)
- db_sales (complex transaction table)
- dunn_tblsoadetails (financial detail table)
- tbltrans_tenants (main business entity table)
- event_header (event management table)

## File Locations

All files are located in:
```
c:\Users\nuest\Documents\FINAL-PropertyManagementSystem\
```

1. TABLE_STRUCTURES.sql - Main schema file
2. TABLE_SUMMARY.txt - Summary reference
3. EXTRACTION_INDEX.md - This index file
4. gates_smm March 3, 2020.sql - Original source file

## Quick Reference

**To find a specific table structure:**
1. Open TABLE_STRUCTURES.sql
2. Search for `-- Table: [table_name]` to find the CREATE TABLE statement

**To understand table relationships:**
1. Look for foreign key references in the table definitions
2. Cross-reference with related tables in same module
3. Use TABLE_SUMMARY.txt to identify tables by category

**To create Laravel migrations:**
1. Reference TABLE_STRUCTURES.sql for exact column definitions
2. Use Laravel Schema builder documentation
3. Follow Laravel naming conventions in migration files
4. Test migrations thoroughly before production

---

**Generated:** October 31, 2025
**Total Extraction Time:** < 1 minute
**All schemas successfully extracted and validated**
