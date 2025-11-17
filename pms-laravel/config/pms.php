<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Property Management System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options specific to the Property
    | Management System application.
    |
    */

    'name' => env('APP_NAME', 'Property Management System'),

    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | Business Rules Configuration
    |--------------------------------------------------------------------------
    */

    'business' => [
        // Late payment penalty rate (percentage per month)
        'late_penalty_rate' => env('PMS_LATE_PENALTY_RATE', 2.0),

        // Grace period before penalties apply (days)
        'penalty_grace_period_days' => env('PMS_PENALTY_GRACE_DAYS', 5),

        // Bounced check penalty (fixed amount)
        'bounced_check_penalty' => env('PMS_BOUNCED_CHECK_PENALTY', 500.00),

        // Payment terms (days after invoice date)
        'default_payment_terms_days' => env('PMS_PAYMENT_TERMS_DAYS', 15),

        // Default billing cycle
        'default_billing_cycle' => env('PMS_DEFAULT_BILLING_CYCLE', 'monthly'),

        // Default billing day of month
        'default_billing_day' => env('PMS_DEFAULT_BILLING_DAY', 1),

        // Minimum lease term (months)
        'minimum_lease_term_months' => env('PMS_MIN_LEASE_TERM', 1),

        // Maximum lease term (months)
        'maximum_lease_term_months' => env('PMS_MAX_LEASE_TERM', 120),

        // Default escalation rate (percentage per year)
        'default_escalation_rate' => env('PMS_DEFAULT_ESCALATION_RATE', 5.0),

        // Days before lease expiry to mark as "expiring"
        'lease_expiring_threshold_days' => env('PMS_LEASE_EXPIRING_DAYS', 60),

        // Security deposit refund timeline (days)
        'deposit_refund_days' => env('PMS_DEPOSIT_REFUND_DAYS', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Configuration
    |--------------------------------------------------------------------------
    */

    'currency' => [
        'code' => env('PMS_CURRENCY_CODE', 'PHP'),
        'symbol' => env('PMS_CURRENCY_SYMBOL', '₱'),
        'decimal_places' => env('PMS_CURRENCY_DECIMALS', 2),
        'thousands_separator' => env('PMS_THOUSANDS_SEPARATOR', ','),
        'decimal_separator' => env('PMS_DECIMAL_SEPARATOR', '.'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Configuration
    |--------------------------------------------------------------------------
    */

    'invoice' => [
        // Invoice number prefix
        'number_prefix' => env('PMS_INVOICE_PREFIX', 'INV'),

        // Invoice number padding (e.g., INV-000001)
        'number_padding' => env('PMS_INVOICE_PADDING', 6),

        // Auto-generate invoices
        'auto_generate' => env('PMS_AUTO_GENERATE_INVOICES', true),

        // Invoice generation day of month
        'generation_day' => env('PMS_INVOICE_GENERATION_DAY', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Configuration
    |--------------------------------------------------------------------------
    */

    'payment' => [
        // Payment number prefix
        'number_prefix' => env('PMS_PAYMENT_PREFIX', 'PAY'),

        // Receipt number prefix
        'receipt_prefix' => env('PMS_RECEIPT_PREFIX', 'OR'),

        // Payment methods
        'methods' => [
            'cash' => 'Cash',
            'check' => 'Check',
            'bank_transfer' => 'Bank Transfer',
            'credit_card' => 'Credit Card',
            'online' => 'Online Payment',
            'pdc' => 'Post-Dated Check',
        ],

        // Check clearance days
        'check_clearance_days' => env('PMS_CHECK_CLEARANCE_DAYS', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Lease Configuration
    |--------------------------------------------------------------------------
    */

    'lease' => [
        // Contract number prefix
        'contract_prefix' => env('PMS_CONTRACT_PREFIX', 'LC'),

        // Application number prefix
        'application_prefix' => env('PMS_APPLICATION_PREFIX', 'LA'),

        // Reservation number prefix
        'reservation_prefix' => env('PMS_RESERVATION_PREFIX', 'RES'),

        // Inquiry number prefix
        'inquiry_prefix' => env('PMS_INQUIRY_PREFIX', 'INQ'),

        // Billing cycles
        'billing_cycles' => [
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
            'semi_annual' => 'Semi-Annual',
            'annual' => 'Annual',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Unit Configuration
    |--------------------------------------------------------------------------
    */

    'unit' => [
        // Unit types
        'types' => [
            'commercial' => 'Commercial',
            'office' => 'Office',
            'residential' => 'Residential',
            'parking' => 'Parking',
            'storage' => 'Storage',
            'kiosk' => 'Kiosk',
        ],

        // Unit statuses
        'statuses' => [
            'vacant' => 'Vacant',
            'occupied' => 'Occupied',
            'reserved' => 'Reserved',
            'maintenance' => 'Under Maintenance',
            'unavailable' => 'Unavailable',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant Configuration
    |--------------------------------------------------------------------------
    */

    'tenant' => [
        // Tenant types
        'types' => [
            'individual' => 'Individual',
            'corporate' => 'Corporate',
        ],

        // Tenant statuses
        'statuses' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'blacklisted' => 'Blacklisted',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Property Configuration
    |--------------------------------------------------------------------------
    */

    'property' => [
        // Property types
        'types' => [
            'mall' => 'Shopping Mall',
            'office_building' => 'Office Building',
            'residential' => 'Residential Complex',
            'mixed_use' => 'Mixed Use',
            'industrial' => 'Industrial Park',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Configuration
    |--------------------------------------------------------------------------
    */

    'maintenance' => [
        // Work order number prefix
        'work_order_prefix' => env('PMS_WORK_ORDER_PREFIX', 'WO'),

        // Request number prefix
        'request_prefix' => env('PMS_MAINTENANCE_REQUEST_PREFIX', 'MR'),

        // Priority levels
        'priorities' => [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ],

        // Work order types
        'types' => [
            'preventive' => 'Preventive',
            'corrective' => 'Corrective',
            'emergency' => 'Emergency',
            'project' => 'Project',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    'pagination' => [
        'default_per_page' => env('PMS_PER_PAGE', 15),
        'max_per_page' => env('PMS_MAX_PER_PAGE', 100),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Uploads
    |--------------------------------------------------------------------------
    */

    'uploads' => [
        // Maximum file size in KB
        'max_file_size' => env('PMS_MAX_FILE_SIZE', 5120), // 5MB

        // Allowed file extensions
        'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx'],

        // Storage disk
        'disk' => env('PMS_UPLOAD_DISK', 'local'),

        // Upload paths
        'paths' => [
            'tenant_documents' => 'tenants/documents',
            'lease_documents' => 'leases/documents',
            'property_images' => 'properties/images',
            'unit_images' => 'units/images',
            'maintenance_attachments' => 'maintenance/attachments',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reports Configuration
    |--------------------------------------------------------------------------
    */

    'reports' => [
        // Default export format
        'default_export_format' => env('PMS_REPORT_FORMAT', 'pdf'),

        // Available export formats
        'export_formats' => ['pdf', 'excel', 'csv'],

        // Aging buckets (days)
        'aging_buckets' => [
            'current' => [0, 30],
            '31-60' => [31, 60],
            '61-90' => [61, 90],
            '91+' => [91, 999999],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Log Configuration
    |--------------------------------------------------------------------------
    */

    'audit' => [
        // Enable audit logging
        'enabled' => env('PMS_AUDIT_ENABLED', true),

        // Events to log
        'events' => [
            'lease_created',
            'lease_activated',
            'lease_terminated',
            'invoice_generated',
            'invoice_cancelled',
            'payment_recorded',
            'payment_voided',
            'penalty_waived',
            'unit_status_changed',
            'user_login',
            'user_logout',
        ],

        // Retention period (days)
        'retention_days' => env('PMS_AUDIT_RETENTION_DAYS', 365),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Configuration
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        // Enable email notifications
        'email_enabled' => env('PMS_EMAIL_NOTIFICATIONS', true),

        // Enable SMS notifications
        'sms_enabled' => env('PMS_SMS_NOTIFICATIONS', false),

        // Notification events
        'events' => [
            'lease_expiring' => true,
            'invoice_generated' => true,
            'payment_received' => true,
            'overdue_invoice' => true,
            'maintenance_request_submitted' => true,
            'maintenance_completed' => true,
        ],

        // Days before lease expiry to send reminder
        'lease_expiry_reminder_days' => [90, 60, 30, 15],

        // Days after invoice due date to send overdue notice
        'overdue_reminder_days' => [7, 14, 30],
    ],

];
