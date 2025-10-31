# Laravel Migration Conversion Examples

This guide shows how to convert the extracted SQL CREATE TABLE statements into Laravel migrations.

## Example 1: Simple Table - Categories

### Original SQL (from TABLE_STRUCTURES.sql)
```sql
CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(100) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

### Laravel Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('categoryId');
            $table->string('categoryName', 100);
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
```

### Alternative (Using Laravel naming conventions)
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Use modern id() method
            $table->string('name', 100);
            $table->timestamps(); // Add created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
```

---

## Example 2: Complex Table - db_sales

### Original SQL (excerpt)
```sql
CREATE TABLE `db_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(30) DEFAULT NULL,
  `tenantid` varchar(30) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(30) DEFAULT NULL,
  `fvcMrcntDsc` text,
  `fnmGrndTtlOld` float(20,2) DEFAULT NULL,
  `fnmGrndTtlNew` float(20,2) DEFAULT NULL,
  `fnmGTDlySls` float(20,2) DEFAULT NULL,
  `fnmGTDscnt` float(20,2) DEFAULT NULL,
  `fnmGTDscntSNR` float(20,2) DEFAULT NULL,
  `fnmGTDscntPWD` float(20,2) DEFAULT NULL,
  `fnmGTDscntGPC` float(20,2) DEFAULT NULL,
  `fnmGTDscntVIP` float(20,2) DEFAULT NULL,
  `fnmGTDscntEMP` float(20,2) DEFAULT NULL,
  `fnmGTDscntREG` float(20,2) DEFAULT NULL,
  `fnmGTDscntOTH` float(20,2) DEFAULT NULL,
  `fnmGTRfnd` float(20,2) DEFAULT NULL,
  `fnmGTCncld` float(20,2) DEFAULT NULL,
  `fnmGTSlsVAT` float(20,2) DEFAULT NULL,
  `fnmGTVATSlsInclsv` float(20,2) DEFAULT NULL,
  `fnmGTVATSlsExclsv` float(20,2) DEFAULT NULL,
  `fnmOffclRcptBeg` float(20,2) DEFAULT NULL,
  `fnmOffclRcptEnd` float(20,2) DEFAULT NULL,
  `fnmGTCntDcmnt` float(20,2) DEFAULT NULL,
  `fnmGTCntCstmr` float(20,2) DEFAULT NULL,
  `fnmGTCntSnrCtzn` float(20,2) DEFAULT NULL,
  `fnmGTLclTax` float(20,2) DEFAULT NULL,
  `fnmGTSrvcChrg` float(20,2) DEFAULT NULL,
  `fnmGTSlsNonVat` float(20,2) DEFAULT NULL,
  `fnmGTRwGrss` float(20,2) DEFAULT NULL,
  `fnmGTLclTaxDly` float(20,2) DEFAULT NULL,
  `fvcWrksttnNmbr` varchar(30) DEFAULT NULL,
  `fnmGTPymntCSH` float(20,2) DEFAULT NULL,
  `fnmGTPymntCRD` float(20,2) DEFAULT NULL,
  `fnmGTPymntOTH` float(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

### Laravel Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbSalesTable extends Migration
{
    public function up()
    {
        Schema::create('db_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mallid', 30)->nullable();
            $table->string('tenantid', 30)->nullable();
            $table->date('fdtTrnsctn')->nullable();
            $table->string('fvcMrchntCd', 30)->nullable();
            $table->longText('fvcMrcntDsc')->nullable();

            // Financial columns (float 20,2)
            $table->decimal('fnmGrndTtlOld', 20, 2)->nullable();
            $table->decimal('fnmGrndTtlNew', 20, 2)->nullable();
            $table->decimal('fnmGTDlySls', 20, 2)->nullable();
            $table->decimal('fnmGTDscnt', 20, 2)->nullable();
            $table->decimal('fnmGTDscntSNR', 20, 2)->nullable();
            $table->decimal('fnmGTDscntPWD', 20, 2)->nullable();
            $table->decimal('fnmGTDscntGPC', 20, 2)->nullable();
            $table->decimal('fnmGTDscntVIP', 20, 2)->nullable();
            $table->decimal('fnmGTDscntEMP', 20, 2)->nullable();
            $table->decimal('fnmGTDscntREG', 20, 2)->nullable();
            $table->decimal('fnmGTDscntOTH', 20, 2)->nullable();
            $table->decimal('fnmGTRfnd', 20, 2)->nullable();
            $table->decimal('fnmGTCncld', 20, 2)->nullable();
            $table->decimal('fnmGTSlsVAT', 20, 2)->nullable();
            $table->decimal('fnmGTVATSlsInclsv', 20, 2)->nullable();
            $table->decimal('fnmGTVATSlsExclsv', 20, 2)->nullable();
            $table->decimal('fnmOffclRcptBeg', 20, 2)->nullable();
            $table->decimal('fnmOffclRcptEnd', 20, 2)->nullable();
            $table->decimal('fnmGTCntDcmnt', 20, 2)->nullable();
            $table->decimal('fnmGTCntCstmr', 20, 2)->nullable();
            $table->decimal('fnmGTCntSnrCtzn', 20, 2)->nullable();
            $table->decimal('fnmGTLclTax', 20, 2)->nullable();
            $table->decimal('fnmGTSrvcChrg', 20, 2)->nullable();
            $table->decimal('fnmGTSlsNonVat', 20, 2)->nullable();
            $table->decimal('fnmGTRwGrss', 20, 2)->nullable();
            $table->decimal('fnmGTLclTaxDly', 20, 2)->nullable();

            // Remaining columns
            $table->string('fvcWrksttnNmbr', 30)->nullable();
            $table->decimal('fnmGTPymntCSH', 20, 2)->nullable();
            $table->decimal('fnmGTPymntCRD', 20, 2)->nullable();
            $table->decimal('fnmGTPymntOTH', 20, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('db_sales');
    }
}
```

---

## Example 3: Table with Indexes - db_syncfilestat

### Original SQL
```sql
CREATE TABLE `db_syncfilestat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refno` varchar(10) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `sales` tinyint(1) DEFAULT '0',
  `discount` tinyint(1) DEFAULT '0',
  `void_refund` tinyint(1) DEFAULT '0',
  `salesperhour` tinyint(1) DEFAULT '0',
  `paymenttype` tinyint(1) DEFAULT '0',
  `reportDate` date DEFAULT NULL,
  `countSync` int(1) DEFAULT NULL,
  `penalty` int(1) DEFAULT '0',
  `uploaded` tinyint(1) DEFAULT '0',
  `VAL_STAT` tinyint(1) DEFAULT '0',
  `sales_stat` tinyint(1) DEFAULT '0',
  `discount_stat` tinyint(1) DEFAULT '0',
  `void_stat` tinyint(1) DEFAULT '0',
  `salesperhour_stat` tinyint(1) DEFAULT '0',
  `paymenttype_stat` tinyint(1) DEFAULT '0',
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`),
  KEY `IDX_refno` (`refno`),
  KEY `IDX_reportDate` (`reportDate`),
  KEY `IDX_TenantID` (`tenantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

### Laravel Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbSyncfilestatTable extends Migration
{
    public function up()
    {
        Schema::create('db_syncfilestat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('refno', 10)->nullable();
            $table->string('tenantID', 20)->nullable();
            $table->boolean('sales')->default(0);
            $table->boolean('discount')->default(0);
            $table->boolean('void_refund')->default(0);
            $table->boolean('salesperhour')->default(0);
            $table->boolean('paymenttype')->default(0);
            $table->date('reportDate')->nullable();
            $table->integer('countSync')->nullable();
            $table->integer('penalty')->default(0);
            $table->boolean('uploaded')->default(0);
            $table->boolean('VAL_STAT')->default(0);
            $table->boolean('sales_stat')->default(0);
            $table->boolean('discount_stat')->default(0);
            $table->boolean('void_stat')->default(0);
            $table->boolean('salesperhour_stat')->default(0);
            $table->boolean('paymenttype_stat')->default(0);
            $table->timestamp('xdatetime')->nullable()->useCurrent();

            // Indexes
            $table->index('id');
            $table->index('refno', 'IDX_refno');
            $table->index('reportDate', 'IDX_reportDate');
            $table->index('tenantID', 'IDX_TenantID');
        });
    }

    public function down()
    {
        Schema::dropIfExists('db_syncfilestat');
    }
}
```

---

## Example 4: Table with Multiple Indexes - dunn_tblsoadetails

### Original SQL (excerpt)
```sql
CREATE TABLE `dunn_tblsoadetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soaNo` varchar(30) NOT NULL,
  `tenantid` varchar(20) NOT NULL,
  `xcode` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `amount` decimal(40,2) NOT NULL DEFAULT '0.00',
  `qty` decimal(40,2) NOT NULL DEFAULT '0.00',
  `paymentamount` decimal(40,2) DEFAULT '0.00',
  `vatamount` decimal(40,2) DEFAULT '0.00',
  `balance` decimal(40,2) DEFAULT '0.00',
  `xdate` date NOT NULL,
  `reference` varchar(100) NOT NULL,
  `xdatetime` datetime NOT NULL,
  `isPenalty` int(1) NOT NULL DEFAULT '0',
  `paymenttype` varchar(15) NOT NULL,
  ... (more fields) ...
  PRIMARY KEY (`id`),
  KEY `tenantid` (`tenantid`(11)),
  KEY `xdate` (`xdate`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
```

### Laravel Migration
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDunnTblsoadetailsTable extends Migration
{
    public function up()
    {
        Schema::create('dunn_tblsoadetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('soaNo', 30);
            $table->string('tenantid', 20);
            $table->string('xcode', 80);
            $table->string('description', 150);
            $table->decimal('amount', 40, 2)->default('0.00');
            $table->decimal('qty', 40, 2)->default('0.00');
            $table->decimal('paymentamount', 40, 2)->default('0.00');
            $table->decimal('vatamount', 40, 2)->default('0.00');
            $table->decimal('balance', 40, 2)->default('0.00');
            $table->date('xdate');
            $table->string('reference', 100);
            $table->dateTime('xdatetime');
            $table->integer('isPenalty')->default('0');
            $table->string('paymenttype', 15);
            // ... more fields ...

            // Indexes
            $table->index(['tenantid']);
            $table->index(['xdate']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dunn_tblsoadetails');
    }
}
```

---

## Type Mapping Reference

### MySQL to Laravel Data Types

| MySQL | Laravel | Notes |
|-------|---------|-------|
| `int(11)` | `$table->integer()` | Or `increments()` for auto-increment |
| `bigint(20)` | `$table->bigInteger()` | For large numbers |
| `varchar(n)` | `$table->string('col', n)` | n is optional |
| `text` | `$table->text()` | For longer text |
| `longtext` | `$table->longText()` | For very long text |
| `date` | `$table->date()` | Date only |
| `datetime` | `$table->dateTime()` | Date and time |
| `time` | `$table->time()` | Time only |
| `float(20,2)` | `$table->decimal(20, 2)` | Use decimal for money |
| `decimal(n,m)` | `$table->decimal(n, m)` | Precise decimal |
| `double` | `$table->double(n, m)` | Large decimals |
| `tinyint(1)` | `$table->boolean()` | For 0/1 values |
| `tinyint(5)` | `$table->tinyInteger()` | For small numbers |
| `timestamp` | `$table->timestamp()` | Use `useCurrent()` for CURRENT_TIMESTAMP |

### Constraints

| Constraint | Laravel | Notes |
|-----------|---------|-------|
| `NOT NULL` | Default (no nullable()) | Fields are not nullable by default |
| `DEFAULT NULL` | `->nullable()` | Make field nullable |
| `DEFAULT 'value'` | `->default('value')` | Set default value |
| `AUTO_INCREMENT` | `$table->increments()` or `id()` | Auto-incrementing primary key |
| `PRIMARY KEY` | `$table->primary()` | Usually auto for id column |
| `KEY name (col)` | `$table->index(['col'], 'name')` | Create an index |
| `UNIQUE` | `$table->unique()` | Make column unique |

---

## Converting Multiple Tables at Once

### Batch Naming Convention
```bash
# Create multiple migration files
php artisan make:migration create_categories_table
php artisan make:migration create_db_sales_table
php artisan make:migration create_db_syncfilestat_table
php artisan make:migration create_dunn_tblsoadetails_table
# ... and so on for all 312 tables
```

### Running All Migrations
```bash
# Run all pending migrations
php artisan migrate

# Rollback all migrations
php artisan migrate:rollback

# Rollback and re-run
php artisan migrate:refresh
```

---

## Important Notes for Property Management System

1. **Tenant Relationships:** Consider creating foreign keys between:
   - `tbltrans_tenants` (main table)
   - `tbltrans_leasingapplication` (linked by tenantid)
   - `tbl_tenantspayments` (linked by tenant)

2. **Financial Precision:** Use `decimal` type for all money fields:
   - Changed from `float(20,2)` to `decimal(20, 2)`
   - Prevents floating-point rounding errors

3. **Timestamps:** Convert old `timestamp` fields to Laravel timestamps:
   - Add `created_at` and `updated_at` to most tables
   - Use `timestamps()` method

4. **Soft Deletes:** Consider adding soft deletes to:
   - Transaction tables
   - Master data tables
   - Audit-required tables

5. **Relationships:** Define Eloquent relationships:
   - One-to-Many: Tenant has many transactions
   - Many-to-Many: Events have many facilities
   - Polymorphic: Various entities can have attachments

---

## Testing Migrations

```php
// In tests
public function test_database_has_required_tables()
{
    $this->assertTrue(Schema::hasTable('categories'));
    $this->assertTrue(Schema::hasTable('tbltrans_tenants'));
    // ... test other tables
}

// Run migrations in testing
php artisan migrate --env=testing

// Verify table structure
php artisan tinker
> Schema::getColumns('categories')
```

---

## Performance Considerations

1. **Indexes:** Already present in extracted SQL, preserved in Laravel
2. **Column Optimization:** Consider renaming to Laravel conventions
3. **Denormalization:** Some tables appear denormalized - consider normalization
4. **Partitioning:** Large transaction tables may benefit from partitioning

---

Generated: October 31, 2025
For use with Laravel database migrations
