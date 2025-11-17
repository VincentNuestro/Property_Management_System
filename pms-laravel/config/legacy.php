<?php

return [
    'connection' => [
        'driver' => 'mysql',
        'host' => env('LEGACY_DB_HOST', '127.0.0.1'),
        'port' => env('LEGACY_DB_PORT', '3306'),
        'database' => env('LEGACY_DB_DATABASE', 'gates_smm3'),
        'username' => env('LEGACY_DB_USERNAME', 'root'),
        'password' => env('LEGACY_DB_PASSWORD', ''),
        'charset' => 'latin1',
        'collation' => 'latin1_swedish_ci',
        'prefix' => '',
        'strict' => false,
        'engine' => null,
    ],

    // Table mapping from legacy to new schema
    'table_mapping' => [
        'properties' => 'tblref_mall',
        'buildings' => 'tblref_bldg',
        'floors' => 'tblref_floorsetup',
        'units' => 'tblref_unit',
        'companies' => 'tbltrans_company',
        'tenants' => 'tbltrans_tenants',
        'inquiries' => 'tbltrans_inquiry',
        'reservations' => 'tbltrans_reservation',
        'lease_applications' => 'tbltrans_leasingapplication',
        'lease_contracts' => 'tblcontract',
        'invoices' => 'dunn_tblsoaheader',
        'invoice_line_items' => 'dunn_tblsoadetails',
        'payments' => 'tbl_tenantspayments',
        'payment_applications' => 'tbltrans_paymentapplogs',
        'maintenance_requests' => 'tblcomplaints',
        'work_orders' => 'tblmaintenance_workorder',
    ],

    // Migration settings
    'chunk_size' => 1000,
    'log_errors' => true,
    'log_file' => storage_path('logs/migration.log'),

    // Data cleaning settings
    'trim_strings' => true,
    'null_empty_strings' => true,
    'validate_emails' => true,
    'default_password' => 'ChangeMe123!',
];
