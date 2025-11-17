# Property Management System - Business Rules

**Version:** 1.0
**Date:** November 17, 2025
**Purpose:** Define business logic, calculations, workflows, and validation rules

---

## Table of Contents

1. [Unit Management Rules](#1-unit-management-rules)
2. [Lease Management Rules](#2-lease-management-rules)
3. [Billing & Invoicing Rules](#3-billing--invoicing-rules)
4. [Payment Processing Rules](#4-payment-processing-rules)
5. [Penalty Calculation Rules](#5-penalty-calculation-rules)
6. [Security Deposit Rules](#6-security-deposit-rules)
7. [Proration Rules](#7-proration-rules)
8. [Escalation Rules](#8-escalation-rules)
9. [Workflow & Approval Rules](#9-workflow--approval-rules)
10. [Data Validation Rules](#10-data-validation-rules)
11. [Business Constraints](#11-business-constraints)

---

## 1. Unit Management Rules

### 1.1 Unit Status Lifecycle

```
Vacant → Reserved → Occupied → (Vacant or Maintenance)
                              ↓
                         Unavailable
```

**Status Definitions:**

| Status | Description | Can be Leased? |
|--------|-------------|----------------|
| `vacant` | Available for lease | ✅ Yes |
| `reserved` | Reservation active | ❌ No |
| `occupied` | Active lease | ❌ No |
| `maintenance` | Under repair | ❌ No |
| `unavailable` | Not for lease | ❌ No |

**Status Transition Rules:**

1. **Vacant → Reserved:**
   - When reservation is created
   - Reservation fee must be paid (or recorded)

2. **Reserved → Occupied:**
   - When lease contract is activated
   - Reservation fee applied to security deposit or first rent

3. **Reserved → Vacant:**
   - Reservation cancelled by tenant
   - Reservation expired (past expiry date)
   - Reservation converted to lease (auto-transition)

4. **Occupied → Vacant:**
   - Lease terminated
   - Lease expired and not renewed
   - Final billing completed

5. **Any → Maintenance:**
   - Manual status change by property manager
   - Emergency repair needed

6. **Maintenance → Vacant:**
   - Maintenance work completed
   - Unit ready for lease

### 1.2 Unit Availability Check

**Before Leasing:**
```
✅ Unit must be 'vacant'
✅ No overlapping active leases for same unit
✅ No pending reservations
✅ Unit not in maintenance
```

### 1.3 Unit Double-Booking Prevention

**Rule:** A unit cannot have overlapping lease contracts.

**Validation:**
```sql
-- Check for overlapping leases
SELECT COUNT(*) FROM lease_contracts lc
JOIN lease_contract_unit lcu ON lc.id = lcu.lease_contract_id
WHERE lcu.unit_id = :unit_id
  AND lc.status IN ('active', 'draft')
  AND (
    (:start_date BETWEEN lc.start_date AND lc.end_date)
    OR (:end_date BETWEEN lc.start_date AND lc.end_date)
    OR (lc.start_date BETWEEN :start_date AND :end_date)
  )
```

---

## 2. Lease Management Rules

### 2.1 Lease Contract Lifecycle

```
Draft → Active → Expiring Soon → Expired / Renewed / Terminated
```

**Status Definitions:**

| Status | Description | Billing Active? |
|--------|-------------|-----------------|
| `draft` | Contract being prepared | ❌ No |
| `active` | Contract in force | ✅ Yes |
| `expiring` | < 60 days to end date | ✅ Yes |
| `expired` | Past end date, not renewed | ❌ No |
| `terminated` | Early termination | ❌ No |
| `renewed` | Replaced by renewal contract | ❌ No |

**Status Transition Rules:**

1. **Draft → Active:**
   - Contract signed (signed_date set)
   - Start date >= today
   - All required fields completed
   - Security deposit received (optional rule)
   - Advance rent received (optional rule)

2. **Active → Expiring:**
   - Automatically set when 60 days before end_date
   - Notification sent to property manager

3. **Active/Expiring → Expired:**
   - Automatically set when current_date > end_date
   - No renewal contract created
   - Final billing generated

4. **Active/Expiring → Renewed:**
   - Renewal contract created and activated
   - Original contract end_date may be extended or not

5. **Active/Expiring → Terminated:**
   - Manual termination by property manager
   - Termination date and reason required
   - Final billing generated
   - Security deposit processing initiated

### 2.2 Lease Term Rules

**Minimum Lease Term:** 1 month
**Maximum Lease Term:** 120 months (10 years)

**Billing Cycle Options:**
- Monthly (default)
- Quarterly (3 months)
- Semi-annual (6 months)
- Annual (12 months)

**Billing Day:**
- Default: Day 1 of the month
- Configurable per contract
- Must be between 1 and 28 (to handle February)

### 2.3 Multi-Unit Leases

**Rule:** One lease contract can cover multiple units.

**Use Cases:**
- Corporate tenants leasing multiple office spaces
- Retail tenants with store + storage units
- Residential tenants with parking spaces

**Billing:**
- Each unit has its own monthly rent
- Total rent = sum of all unit rents
- Can have shared charges (e.g., one association dues charge)

### 2.4 Lease Renewal Rules

**Renewal Process:**
1. Identify expiring contracts (60-90 days before end)
2. Send renewal notice to tenant
3. Tenant accepts/declines renewal
4. If accepted:
   - Create new lease contract (renewal)
   - Apply escalation rate (if any)
   - Update charges
   - Set new start_date = old end_date + 1 day
   - Mark old contract as 'renewed'
5. If declined:
   - Schedule move-out
   - Generate final billing
   - Process security deposit refund

**Renewal Escalation:**
```php
$newMonthlyRent = $oldMonthlyRent * (1 + $escalationRate);

// Example: 5% escalation
// Old rent: 30,000
// New rent: 30,000 * 1.05 = 31,500
```

### 2.5 Lease Termination Rules

**Early Termination:**
- Requires property manager approval
- Termination reason must be documented
- Termination penalties may apply (per contract terms)

**Termination Process:**
1. Set termination_date
2. Set status = 'terminated'
3. Update unit status to 'vacant'
4. Generate final invoice:
   - Prorated rent (if mid-month)
   - Outstanding charges
   - Penalties (if applicable)
   - Subtract security deposit (if applicable)
5. Process security deposit refund
6. Close out payment records

**Move-Out Billing:**
```
Final Bill =
  + Prorated rent (up to termination date)
  + Outstanding utility charges
  + Unpaid previous invoices
  + Late penalties
  + Termination penalty (if applicable)
  - Security deposit
  - Advance rent credit
= Net Amount Due (or Refund)
```

---

## 3. Billing & Invoicing Rules

### 3.1 Invoice Generation Timing

**Monthly Billing:**
- Generated on the billing_day of each month
- For the current billing period (e.g., Jan 1-31)
- Due date = invoice_date + payment_terms_days

**Example:**
```
Lease: Monthly billing, billing_day = 1, payment_terms = 15 days
Invoice Date: January 1, 2025
Billing Period: January 1-31, 2025
Due Date: January 16, 2025
```

**Quarterly/Annual Billing:**
- Generated on start of billing period
- Covers 3/12 months in advance

### 3.2 Invoice Line Items

**Standard Charges (Recurring):**
1. **Base Rent** - from lease_contract_unit.monthly_rent
2. **Association Dues** - from contract_charges
3. **Parking Fees** - from contract_charges
4. **Utilities** - from meter readings (if applicable)
5. **Other Recurring Charges** - from contract_charges

**Ad-Hoc Charges (One-Time):**
- Repairs billable to tenant
- Penalty charges
- Special services
- Event/facility fees

**Invoice Calculation:**
```php
Subtotal = Sum of all line items
Tax Amount = Sum of (taxable line items * tax_rate)
Discount = Applied discounts (if any)
Total = Subtotal + Tax - Discount
```

### 3.3 Invoice Status Lifecycle

```
Draft → Issued → Partially Paid → Paid
                      ↓
                  Overdue (if past due_date)
                      ↓
                  Cancelled (manual)
```

**Status Rules:**

| Status | Condition |
|--------|-----------|
| `draft` | Invoice created, not yet issued |
| `issued` | Invoice sent to tenant, balance > 0 |
| `partially_paid` | paid_amount > 0 AND balance > 0 |
| `paid` | balance = 0 |
| `overdue` | current_date > due_date AND balance > 0 |
| `cancelled` | Manual cancellation by accounting |

**Auto-Status Updates:**
```php
// After payment application
if ($invoice->balance == 0) {
    $invoice->status = 'paid';
} elseif ($invoice->paid_amount > 0) {
    $invoice->status = 'partially_paid';
} elseif (now() > $invoice->due_date && $invoice->balance > 0) {
    $invoice->status = 'overdue';
}
```

### 3.4 Invoice Cancellation Rules

**Allowed:**
- Draft invoices (not yet issued)
- Issued invoices with no payments applied

**Not Allowed:**
- Invoices with payments applied (use credit memo instead)
- Paid invoices

**Process:**
1. Set status = 'cancelled'
2. Set cancelled_at timestamp
3. Record cancellation_reason
4. Create audit log entry

---

## 4. Payment Processing Rules

### 4.1 Payment Application Logic

**FIFO (First In, First Out) - Oldest Invoices First:**

```php
// Example
Tenant has 3 unpaid invoices:
  Invoice #001: Balance = 10,000 (due Jan 15)
  Invoice #002: Balance = 15,000 (due Feb 15)
  Invoice #003: Balance = 20,000 (due Mar 15)

Payment received: 30,000

Application:
1. Apply 10,000 to Invoice #001 → Paid in full
2. Apply 15,000 to Invoice #002 → Paid in full
3. Apply 5,000 to Invoice #003 → Partial payment, balance = 15,000
4. Unapplied amount: 0
```

**Overpayment Handling:**

```php
// If payment > total outstanding invoices
Payment: 50,000
Total Outstanding: 40,000

Application:
- Apply 40,000 to invoices
- Unapplied amount: 10,000 (credit balance)

Options:
1. Hold as credit for future invoices
2. Refund to tenant
3. Apply to next month's invoice
```

### 4.2 Payment Methods

| Method | Description | Requires Clearing? |
|--------|-------------|-------------------|
| `cash` | Cash payment | No (immediate) |
| `check` | Personal/company check | Yes (3-5 business days) |
| `bank_transfer` | Bank deposit/transfer | Yes (1-2 days) |
| `credit_card` | Credit card payment | No (immediate) |
| `online` | Online payment gateway | No (immediate) |
| `pdc` | Post-dated check | Yes (on check date) |

**Payment Status:**

| Status | Description |
|--------|-------------|
| `pending` | Awaiting clearance/verification |
| `cleared` | Payment cleared, applied to invoices |
| `bounced` | Check bounced, payment reversed |
| `cancelled` | Payment cancelled/voided |

### 4.3 Post-Dated Check (PDC) Rules

**PDC Lifecycle:**
1. **Received:** Payment recorded with status = 'pending', check_date set
2. **Scheduled:** Awaits check_date for deposit
3. **Deposited:** On check_date, status → 'cleared', applied to invoices
4. **Bounced:** If check bounces, status → 'bounced', revert invoice applications

**PDC Management:**
- Store check details: check_number, check_date, bank_name
- Track deposit schedule
- Send reminders before check_date
- Bounced check penalties apply

### 4.4 Payment Reversal Rules

**When to Reverse:**
- Check bounced
- Payment error
- Duplicate payment

**Reversal Process:**
1. Set payment status = 'cancelled' or 'bounced'
2. Remove payment applications
3. Restore invoice balances
4. Create audit log
5. Apply bounced check penalty (if applicable)

---

## 5. Penalty Calculation Rules

### 5.1 Late Payment Penalty

**Default Rule:** 2% per month (or fraction thereof) on outstanding balance

**Calculation:**
```php
$daysOverdue = now()->diffInDays($invoice->due_date);
$monthsOverdue = ceil($daysOverdue / 30);
$penaltyRate = 0.02; // 2% per month
$penaltyAmount = $invoice->balance * $penaltyRate * $monthsOverdue;

// Example
Invoice Balance: 30,000
Days Overdue: 45 days (2 months)
Penalty: 30,000 * 0.02 * 2 = 1,200
```

**Penalty Application:**
- Add penalty as separate invoice line item
- OR create separate penalty invoice
- Accrued monthly on overdue invoices

**Penalty Waiver:**
- Requires accounting/manager approval
- Reason must be documented
- Audit log entry created

### 5.2 Bounced Check Penalty

**Fixed Amount:** 500 per bounced check (configurable)

**Process:**
1. Reverse payment application
2. Add bounced check penalty to invoice
3. Mark check as bounced
4. Notify tenant

### 5.3 Penalty Grace Period

**Optional:** 5-day grace period before penalty applies

```php
if ($daysOverdue > $gracePeriod) {
    // Apply penalty
}
```

---

## 6. Security Deposit Rules

### 6.1 Deposit Collection

**Timing:** Before or upon lease activation

**Amount:**
- Typically 1-3 months rent
- Defined in lease contract
- Separate from advance rent

**Accounting:**
- Recorded as liability (refundable)
- Not revenue until applied

### 6.2 Deposit Application

**When Applied:**
1. **Lease Termination:**
   - Offset against final bill
   - Deduct unpaid charges
   - Deduct damages/repairs
   - Refund balance to tenant

2. **Default:**
   - Applied to severely overdue invoices
   - Requires tenant notification

**Example Final Bill:**
```
Final Charges:
  Prorated Rent:        5,000
  Utilities:            2,000
  Damages:              3,000
  Late Penalties:       1,000
  Total Charges:       11,000

Security Deposit:      15,000
Refund to Tenant:       4,000
```

### 6.3 Deposit Refund

**Timeline:** Within 30 days of lease termination

**Conditions for Full Refund:**
- No outstanding balances
- No damages to unit
- All keys/access cards returned
- Unit inspection passed

**Partial Refund:**
- Deductions itemized and documented
- Tenant receives statement of deductions

---

## 7. Proration Rules

### 7.1 Move-In Proration

**Rule:** Charge only for days occupied in first partial month

**Calculation:**
```php
$daysInMonth = Carbon::parse($moveInDate)->daysInMonth;
$daysOccupied = $daysInMonth - $moveInDate->day + 1;
$proratedRent = ($monthlyRent / $daysInMonth) * $daysOccupied;

// Example
Move-In Date: January 15
Days in January: 31
Days Occupied: 17 (Jan 15-31)
Monthly Rent: 30,000
Prorated Rent: (30,000 / 31) * 17 = 16,451.61
```

### 7.2 Move-Out Proration

**Rule:** Charge only for days occupied in last partial month

**Calculation:**
```php
$daysInMonth = Carbon::parse($moveOutDate)->daysInMonth;
$daysOccupied = $moveOutDate->day;
$proratedRent = ($monthlyRent / $daysInMonth) * $daysOccupied;

// Example
Move-Out Date: March 20
Days in March: 31
Days Occupied: 20 (Mar 1-20)
Monthly Rent: 30,000
Prorated Rent: (30,000 / 31) * 20 = 19,354.84
```

### 7.3 Proration for Other Charges

**Association Dues:** Prorated same as rent
**Utilities:** Actual usage (meter reading)
**Parking:** Prorated if monthly, full if reserved

---

## 8. Escalation Rules

### 8.1 Rent Escalation

**Definition:** Scheduled rent increase during lease term

**Typical Escalation:**
- **Rate:** 5-10% per year
- **Frequency:** Annual
- **Application:** On anniversary date or calendar year

**Calculation:**
```php
$newRent = $currentRent * (1 + $escalationRate);

// Example: 5% annual escalation
Year 1: 30,000
Year 2: 30,000 * 1.05 = 31,500
Year 3: 31,500 * 1.05 = 33,075
```

**Implementation:**
1. Define escalation schedule in lease contract
2. Auto-update charges on escalation date
3. Notify tenant before increase
4. Reflect in next billing cycle

### 8.2 CPI-Based Escalation

**Alternative:** Escalation based on Consumer Price Index (CPI)

```php
$newRent = $baseRent * (currentCPI / baseCPI);
```

---

## 9. Workflow & Approval Rules

### 9.1 Lease Approval Workflow

```
Application Submitted → Under Review → Approved/Rejected
                             ↓
                      (If Approved)
                             ↓
                    Contract Prepared (Draft)
                             ↓
                    Contract Sent for Signing
                             ↓
                    Contract Signed → Active
```

**Approval Requirements:**
- Credit check passed (if required)
- Background verification completed
- All required documents submitted
- Deposit payment confirmed

### 9.2 Invoice Approval Workflow

**For Large/Special Invoices:**
```
Draft → Pending Approval → Approved → Issued
```

**Standard Monthly Invoices:**
- Auto-generated and auto-issued (no approval needed)

### 9.3 Payment Void/Cancellation Approval

**Requires:**
- Manager-level approval
- Documented reason
- Cannot void if >30 days old (requires adjustment instead)

### 9.4 Penalty Waiver Approval

**Requires:**
- Accounting manager or property manager approval
- Valid business reason
- Documented in system

---

## 10. Data Validation Rules

### 10.1 Lease Contract Validation

```php
✅ start_date must be >= today (or within 90 days past for backdating)
✅ end_date must be > start_date
✅ lease_term_months must match (start_date to end_date)
✅ At least one unit must be selected
✅ All selected units must be 'vacant' or 'reserved'
✅ monthly_rent must be > 0
✅ security_deposit must be >= 0
✅ billing_cycle must be valid enum
✅ billing_day must be between 1-28
```

### 10.2 Invoice Validation

```php
✅ invoice_date must be <= today
✅ due_date must be >= invoice_date
✅ billing_period_start must be < billing_period_end
✅ total_amount must be > 0
✅ Must have at least one line item
✅ Sum of line items must equal subtotal
```

### 10.3 Payment Validation

```php
✅ payment_date must be <= today
✅ amount must be > 0
✅ payment_method must be valid enum
✅ If check: check_number and bank_name required
✅ If PDC: check_date must be > today
✅ Cannot apply more than payment amount to invoices
```

### 10.4 Unit Validation

```php
✅ unit_code must be unique
✅ area_sqm must be > 0
✅ base_rent must be >= 0
✅ Must belong to a property
✅ If building specified, building must belong to same property
✅ If floor specified, floor must belong to same building
```

---

## 11. Business Constraints

### 11.1 Data Integrity Constraints

1. **No Orphan Records:**
   - Every unit must belong to a property
   - Every invoice must have a tenant and property
   - Every payment must reference a tenant

2. **No Overlapping Leases:**
   - Validated before lease creation/activation
   - One unit cannot be leased to multiple tenants for overlapping periods

3. **Financial Accuracy:**
   - Invoice total = subtotal + tax - discount
   - Invoice balance = total - paid_amount
   - Payment applied_amount <= payment amount

4. **Status Consistency:**
   - Unit status must reflect current lease state
   - Invoice status must reflect payment state
   - Lease status must reflect current date vs. end_date

### 11.2 Deletion Rules

**Cannot Delete:**
- Properties with active leases
- Units with active leases
- Tenants with active leases or unpaid invoices
- Invoices with payments applied (cancel instead)
- Payments that are cleared (void instead)

**Soft Delete:**
- All major entities use soft deletes
- Data retained for audit and reporting
- Can be restored if needed

### 11.3 Audit Requirements

**Audit Logged Actions:**
- Lease creation, activation, termination
- Invoice generation, cancellation
- Payment recording, voiding
- Penalty waiver
- Manual status changes
- User login/logout

**Audit Log Contains:**
- User who performed action
- Timestamp
- Action type
- Affected record (type + ID)
- Old values → New values
- Reason/notes (if applicable)

---

## 12. Reporting Business Rules

### 12.1 Occupancy Report

**Definition:** Percentage of occupied units vs. total available units

**Calculation:**
```php
$totalUnits = Unit::whereIn('status', ['vacant', 'occupied', 'reserved'])->count();
$occupiedUnits = Unit::where('status', 'occupied')->count();
$occupancyRate = ($occupiedUnits / $totalUnits) * 100;
```

**Filter Options:**
- By property
- By building
- By unit type
- By date (historical occupancy)

### 12.2 Rent Roll Report

**Definition:** List of all active leases with monthly rent

**Columns:**
- Tenant name
- Unit code(s)
- Lease start/end dates
- Monthly rent
- Total monthly income per property

**Purpose:** Cash flow projection

### 12.3 Aging of Receivables

**Definition:** Outstanding balances grouped by age

**Buckets:**
- Current (0-30 days)
- 31-60 days
- 61-90 days
- 91+ days overdue

**Calculation:**
```php
$daysOverdue = now()->diffInDays($invoice->due_date);

if ($daysOverdue <= 30) $bucket = 'current';
elseif ($daysOverdue <= 60) $bucket = '31-60';
elseif ($daysOverdue <= 90) $bucket = '61-90';
else $bucket = '91+';
```

### 12.4 Collection Report

**Definition:** Payments received over a period

**Metrics:**
- Total collections
- Collections by property
- Collections by payment method
- Collections by tenant

**Purpose:** Cash flow tracking, financial reporting

---

## CONCLUSION

These business rules define the core logic of the Property Management System. All implementations must adhere to these rules to ensure:

✅ **Data Integrity** - Consistent and accurate data
✅ **Financial Accuracy** - Correct billing and payment processing
✅ **Workflow Compliance** - Proper approval and status transitions
✅ **Audit Trail** - Transparent and traceable operations

**Implementation Notes:**
- Encode critical rules in database constraints
- Validate rules in Form Requests
- Enforce rules in Service/Action classes
- Document exceptions in audit logs
- Write tests for all business rules

---

**Document Version:** 1.0
**Author:** Laravel Migration Team
**Date:** November 17, 2025
