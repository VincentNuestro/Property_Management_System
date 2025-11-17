# Legacy Property Management System - Analysis Report

**Analysis Date:** November 17, 2025
**Database:** gates_smm3
**Total Tables:** 312
**Technology Stack:** PHP4/PHP5, MySQL 5.6.17, jQuery, Bootstrap

---

## Executive Summary

The legacy Property Management System is a comprehensive application managing real estate properties, units, tenants, leases, billing, payments, maintenance, and reporting. The system was built using PHP4/PHP5 without a modern framework, resulting in tightly coupled code with mixed concerns.

**Key Findings:**
- **Scale:** 312 database tables covering extensive business domains
- **Architecture:** Procedural PHP with session-based authentication
- **Database:** MySQL with InnoDB engine, latin1 charset
- **Security Issues:** MD5 password hashing, SQL injection vulnerabilities, hardcoded credentials
- **Code Quality:** Hungarian notation, mixed HTML/PHP, no separation of concerns
- **Business Logic:** Complex billing rules, lease management, and multi-property support

---

## 1. MODULE INVENTORY

### 1.1 Core Business Modules

#### **Dashboard & Reporting**
- Main dashboard with KPIs and metrics
- Multiple report types (17+ report categories)
- Audit trail and logging system

#### **Property & Unit Management**
- Properties/Malls (`tblref_mall`)
- Buildings (`tblref_bldg`)
- Floors (`tblref_floorsetup`)
- Units/Spaces (`tblref_unit`, `tblref_unit_amenities`)
- Unit classifications and types
- Floor plans and unit coordinates (graphical layout system)

#### **Tenant Management**
- Tenant/Company records (`tbltrans_tenants`, `tbltrans_company`)
- Contact persons and relationships
- Corporate tenants with multiple contacts
- Tenant documents and requirements
- Tenant portal for self-service

#### **Leasing Workflow**
- Inquiry tracking (`tbltrans_inquiry`)
- Leads management (`tbltrans_leads`)
- Reservations (`tbltrans_reservation`)
- Leasing applications (`tbltrans_leasingapplication`)
- Proposals and counter-proposals (`tbltrans_proposal`)
- Contract signing workflow
- Lease renewals (`tbltrans_renew_contract`)

#### **Contract & Lease Management**
- Contract master data (`tblcontract`)
- Charge escalations (`tbltrans_escalation`, `tbltrans_chargeesca`)
- Rental rates and charges
- Security deposits and advances
- Lease terms and conditions

#### **Billing & Invoicing**
- Statement of Accounts (SOA) system (`dunn_tblsoaheader`, `dunn_tblsoadetails`)
- Charge types and categories (`tblref_charges`, `tblref_charges_type`)
- Billing periods and profiles
- Processed bills (`tbltrans_processedbill`, `tbltrans_processedsoa`)
- Penalty calculations (`tblref_penalty`)
- Operational charges

#### **Payments & Collections**
- Payment records (`tbl_tenantspayments`, `tbltrans_paymentapplogs`)
- Post-dated checks (PDC) management (`tbltrans_pdc`)
- Payment schedules (`tblref_paymentsched`)
- Bank information and payment types
- Aging reports (`dunn_aging`)

#### **Maintenance Management**
- Work orders (`tblmaintenance_workorder`, `tblmaintenance_workorderlist`)
- Complaints (`tblcomplaints`, `tblcomplaintscode`)
- Asset management (`tblref_asset`, `tblasset_maintenance_h/d`)
- Equipment tracking (`tblmaintenance_equip`)
- Maintenance budget (`tblref_budget`)
- Preventive maintenance tasks
- House rules violations (`tblmaintenance_hrviolators`)

#### **Events & Facilities**
- Event management (`event_header`, `event_facilities`)
- Event requirements and resources
- Equipment and manpower allocation

### 1.2 Supporting Modules

#### **User Management & Access Control**
- Users (`tbluser`)
- Groups/Roles (`tblgroups`)
- Group access permissions (`tblref_groupaccess`, `tblref_usergroupaccess`)
- Multi-property access control
- Audit logging (`tbllog_sheet`, `tbllogs_per_trans`)

#### **Tenant Requests & Approvals**
- Tenant requests (`tbltrans_tenantsrequest`)
- Approval workflows (`tblref_apprlist`)
- Request items and visitors

#### **System Configuration**
- System setup (`tblsys_setup`, `tblsys_setup2`)
- Connection setup (`tblsys_connsetup`)
- Mall/property configuration
- Reference data (employees, positions, departments)

#### **Mobile App Integration**
- Android app tables (`pmls_android_*`)
- Location and task tracking
- Worker task management

#### **Sales & POS System**
- Separate sales tracking for different divisions
- Database sets: `db_*`, `fdb_*`, `sdb_*`
- Sales transactions, discounts, voids, refunds
- Hourly sales data

#### **Mall Directory System**
- Shop directory (`mall_directory_shops`)
- Floor maps with coordinates
- Routing system
- Search tracking

#### **Accreditation**
- Vendor/supplier accreditation (`tblaccreditation`)
- Accreditation documents and logs

#### **Communication**
- Chat system (`tblchat_header`, `tblchat_log`)
- Tenant chat portal

---

## 2. DATABASE SCHEMA ANALYSIS

### 2.1 Table Categories

| Category | Count | Prefix | Purpose |
|----------|-------|--------|---------|
| Reference/Master Data | 90+ | `tblref_*`, `ref_*` | Lookup tables, configuration |
| Transactions | 70+ | `tbltrans_*` | Business transactions |
| Maintenance | 20+ | `tblmaintenance_*` | Work orders, assets |
| Events | 11 | `event_*` | Event management |
| Sales/POS | 24 | `db_*`, `fdb_*`, `sdb_*` | Point-of-sale data |
| Billing | 15+ | `dunn_*`, `tbl_*` | SOA and billing |
| System | 3 | `tblsys_*` | System configuration |
| Users | 5 | `tbluser`, `tblgroups` | Authentication, authorization |
| Mobile App | 9 | `pmls_android_*` | Mobile integration |
| Directory | 9 | `mall_directory_*` | Mall directory system |

### 2.2 Key Database Tables

#### **Core Entities**

**Properties/Malls** (`tblref_mall`)
- Property master data
- Multi-property support
- Status tracking

**Buildings** (`tblref_bldg`)
- Building information per property
- Wings/sections (`tblref_wing`)

**Units** (`tblref_unit`)
- Unit code, number, floor
- Size (SQM), type, classification
- Status: vacant, occupied, reserved
- Rental rates and charges
- Coordinates for floor plans

**Tenants** (`tbltrans_tenants`)
- Tenant information (individual/corporate)
- Contact details
- Related company (`tbltrans_company`)
- Multiple contact persons
- Status and classification

**Leasing Applications** (`tbltrans_leasingapplication`)
- Application details
- Requirements checklist
- Affiliated companies
- Down payment tracking

**Contracts** (`tblcontract`)
- Lease contract master
- Links tenant to unit(s)
- Contract terms
- Charge definitions

**SOA Header/Details** (`dunn_tblsoaheader`, `dunn_tblsoadetails`)
- Billing statements
- Line items with charges
- Payment status tracking
- Aging buckets

**Payments** (`tbl_tenantspayments`, `tbltrans_paymentapplogs`)
- Payment transactions
- Payment application to invoices
- Payment types and methods

**Work Orders** (`tblmaintenance_workorder`)
- Maintenance requests
- Assignment and tracking
- Cost tracking

### 2.3 Schema Characteristics

**Naming Conventions:**
- Mixed case table names (not Laravel standard)
- Hungarian notation in columns: `vc*` (varchar), `n*` (number), `f*` (float), `d*` (date)
- Inconsistent primary key naming

**Data Types:**
- `int(11)` for IDs
- `varchar(n)` for text
- `float(20,2)` and `decimal` for currency
- `date`, `datetime`, `time` for temporal data
- `text` for long content
- `tinyint` for booleans

**Issues:**
- No foreign key constraints (referential integrity managed in code)
- latin1 charset (should migrate to utf8mb4)
- Missing indexes on frequently queried columns
- No `created_at`/`updated_at` timestamps on most tables
- No soft deletes

---

## 3. CODE STRUCTURE ANALYSIS

### 3.1 File Organization

```
/
├── index.php (main entry point)
├── mainclass.php (220KB - main business logic)
├── connect.php (database connection)
├── process.php (AJAX handler)
├── loginpage.php (authentication UI)
├── /setup/ (system configuration)
├── /dashboard/ (dashboard views)
├── /tenants/ (tenant management)
├── /billing/ (billing module)
├── /reports/ (17+ report types)
├── /maintenance/ (work orders, complaints)
├── /leasingmodules/ (inquiry, reservation)
├── /leasingapplication/
├── /leads/ (sales pipeline)
├── /events/
├── /tenantportal/
└── /assets/ (CSS, JS, images)
```

### 3.2 Code Patterns

**Architecture:**
- Procedural PHP with minimal OOP
- Session-based authentication
- Direct database queries (no ORM)
- Mixed HTML/PHP in views
- AJAX-driven UI updates

**Common Patterns:**
```php
// Database queries
$result = mysql_query("SELECT ...", $connection);
$row = mysql_fetch_array($result);

// Session management
$_SESSION['MMS-UserID']
$_SESSION['MMS-Access']
$_SESSION['MMS-Designation']

// ID generation
createidno($prefix, $table, $column)

// Form handling via switch
switch($_POST["form"]) {
    case 'ActionName':
        // Handle action
        break;
}
```

### 3.3 Security Vulnerabilities

❌ **Critical Issues:**
1. **SQL Injection:** Direct concatenation of user input
   ```php
   mysql_query("SELECT * FROM tbluser WHERE username = '". $_POST["Username"] ."'");
   ```

2. **Weak Password Hashing:** MD5 (easily cracked)
   ```php
   md5($_POST["Password"].$userid.'@GS')
   ```

3. **Hardcoded Credentials:**
   ```php
   if($_POST['Auth'] == "h3ll0p@nd@")
   ```

4. **No CSRF Protection**

5. **Insecure Session Management**

6. **No Input Validation/Sanitization**

---

## 4. BUSINESS LOGIC ANALYSIS

### 4.1 Leasing Workflow

```
Inquiry → Leads → Reservation → Leasing Application →
Proposal → Counter-Proposal → Contract Signing → Active Lease →
Renewal/Termination
```

**Key Features:**
- Multi-step sales pipeline
- Approval workflows
- Document requirements tracking
- Reservation with deposit
- Contract generation

### 4.2 Billing & Collection

**Billing Cycle:**
1. Generate monthly SOA based on contract charges
2. Apply escalations (rental increases)
3. Add utility charges (meter readings)
4. Add penalties for late payments
5. Track payment applications
6. Generate aging reports

**Charge Types:**
- Base rent
- Association dues
- Parking fees
- Utilities (water, electricity)
- CAM (Common Area Maintenance)
- Ad-hoc charges
- Penalties

**Payment Processing:**
- Multiple payment methods
- Partial payments supported
- Overpayment tracking
- PDC (post-dated check) management
- Security deposit application

### 4.3 Maintenance Operations

**Work Order Lifecycle:**
1. Request submitted (tenant or staff)
2. Assignment to technician/vendor
3. Work execution
4. Cost tracking
5. Completion and sign-off
6. Billing (if billable to tenant)

**Preventive Maintenance:**
- Scheduled tasks
- Recurring maintenance
- Equipment tracking

### 4.4 Multi-Property Support

- Users can access multiple properties
- Property-scoped data
- Consolidated reporting across properties
- Property-specific configurations

---

## 5. REPORTING CAPABILITIES

### 5.1 Existing Reports

| Report Type | Purpose | Key Filters |
|-------------|---------|-------------|
| Occupancy Report | Vacancy tracking | Property, Date |
| Rent Roll | Active leases | Property, Status |
| Aging of Receivables | Collections | Age buckets, Tenant |
| Collection Report | Payment history | Date range, Property |
| Lease Expiry | Expiring contracts | Date range, Property |
| Sales Audit | Tenant sales tracking | Date, Tenant, Property |
| Tenant Sales Report | POS sales analysis | Multiple dimensions |
| Tenant History | Tenant lifecycle | Tenant, Date range |
| Unit History | Unit occupancy log | Unit, Date range |
| Penalty Report | Late payment penalties | Date, Property |
| Application Report | Leasing pipeline | Status, Date |
| Inquiry Report | Leads tracking | Source, Status |
| Violation Report | House rules violations | Type, Date |
| Complaint Report | Maintenance complaints | Status, Priority |
| Audit Trail | User activity log | User, Action, Date |

### 5.2 Export Capabilities

- CSV/Excel export via PHPExcel library
- PDF generation (likely using TCPDF)
- On-screen display with pagination

---

## 6. PAIN POINTS & TECHNICAL DEBT

### 6.1 Code Quality Issues

❌ **Major Problems:**
- **No Framework:** Reinventing common patterns
- **Code Duplication:** Similar logic repeated across modules
- **God Objects:** `mainclass.php` is 220KB
- **Mixed Concerns:** Business logic, data access, and presentation mixed
- **Difficult to Test:** No dependency injection, tight coupling
- **Poor Maintainability:** Hard to understand, modify, or extend

### 6.2 Database Issues

❌ **Problems:**
- **No Referential Integrity:** Foreign keys not enforced
- **Inconsistent Naming:** Mixed conventions
- **Missing Indexes:** Performance issues on large datasets
- **No Soft Deletes:** Data permanently deleted
- **No Audit Trail:** Most tables lack `created_at`/`updated_at`

### 6.3 Security Issues

❌ **Critical:**
- SQL injection vulnerabilities throughout
- Weak password hashing (MD5)
- No CSRF protection
- Inadequate input validation
- Session fixation vulnerabilities

### 6.4 Performance Issues

⚠️ **Concerns:**
- N+1 query problems
- Missing indexes
- Large result sets loaded into memory
- No caching layer
- Inefficient queries

### 6.5 Scalability Limitations

⚠️ **Limitations:**
- Monolithic architecture
- Session-based state (difficult to scale horizontally)
- No queue system for background jobs
- No API for third-party integrations

---

## 7. POSITIVE ASPECTS TO PRESERVE

✅ **Strengths:**
- **Comprehensive Feature Set:** Covers all PMS needs
- **Real-World Tested:** Production system with actual usage
- **Rich Domain Model:** Complex business rules well-defined
- **Extensive Reporting:** Covers stakeholder needs
- **Multi-Property Support:** Scalable to multiple locations
- **Workflow Management:** Approval and status tracking
- **Document Management:** File uploads and tracking
- **Mobile Integration:** Android app support

---

## 8. KEY ENTITIES & RELATIONSHIPS

```
Property (Mall)
├── Buildings
│   ├── Floors
│   │   └── Units
│   │       ├── Amenities
│   │       ├── Coordinates (floor plan)
│   │       └── Status History
│   └── Wings/Sections
│
Tenant/Company
├── Contact Persons
├── Documents
├── Leasing Applications
│   ├── Requirements
│   └── Affiliated Companies
└── Contracts
    ├── Units (many-to-many)
    ├── Charges
    │   ├── Base Charges
    │   └── Escalations
    ├── Billing
    │   ├── SOA Header
    │   └── SOA Details (line items)
    ├── Payments
    │   └── Payment Application
    └── Renewal Contracts

Work Orders
├── Assigned to: Staff/Vendor
├── Related to: Unit
├── Charges (billable items)
└── Status tracking

Events
├── Facilities
├── Manpower
├── Equipment
└── Requirements
```

---

## 9. MIGRATION PRIORITIES

### Phase 1: Foundation (Weeks 1-2)
1. Laravel 11 setup with auth
2. Core entity migrations
3. Master data modules
4. User & permission system

### Phase 2: Core Business (Weeks 3-5)
5. Property, Building, Unit management
6. Tenant management
7. Lease workflow (inquiry → contract)
8. Basic reporting

### Phase 3: Financial (Weeks 6-7)
9. Billing engine
10. Payment processing
11. Collections & aging

### Phase 4: Operations (Week 8)
12. Maintenance & work orders
13. Events management

### Phase 5: Advanced (Weeks 9-10)
14. Advanced reports
15. Data migration tools
16. Testing & documentation

---

## 10. RECOMMENDATIONS

### 10.1 Must-Have Improvements

1. **Framework Adoption:** Laravel 11 for modern architecture
2. **Security Hardening:** Bcrypt passwords, prepared statements, CSRF protection
3. **Clean Architecture:** Separation of concerns, dependency injection
4. **Database Normalization:** Add foreign keys, indexes, timestamps
5. **API-First Design:** Enable mobile and third-party integrations
6. **Queue System:** Background jobs for billing, notifications
7. **Caching:** Redis/Memcached for performance

### 10.2 Nice-to-Have Enhancements

1. **Real-time Notifications:** WebSockets for instant updates
2. **Advanced Analytics:** Business intelligence dashboard
3. **Mobile App:** React Native or Flutter
4. **Document OCR:** Auto-extract data from uploaded documents
5. **Payment Gateway Integration:** Online payments
6. **Email/SMS Notifications:** Automated reminders
7. **Multi-tenancy:** SaaS model for multiple companies

---

## CONCLUSION

The legacy Property Management System is a **feature-rich, production-tested application** with comprehensive business logic. However, it suffers from significant **technical debt, security vulnerabilities, and maintainability issues**.

The migration to Laravel 11 will address these issues while preserving and enhancing the robust business functionality. The new system will be:

- ✅ **Secure** - Modern authentication, authorization, and input validation
- ✅ **Maintainable** - Clean architecture, testable code, separation of concerns
- ✅ **Scalable** - Queue system, caching, API-ready
- ✅ **Fast** - Optimized queries, eager loading, indexes
- ✅ **Modern** - Responsive UI, mobile-friendly, real-time updates

**Next Step:** Architecture design and implementation plan.

---

**Document Version:** 1.0
**Author:** Laravel Migration Team
**Date:** November 17, 2025
