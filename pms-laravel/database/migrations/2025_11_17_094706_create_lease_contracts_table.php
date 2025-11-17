<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lease_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('contract_number', 100)->unique();
            $table->unsignedBigInteger('lease_application_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('lease_term_months');
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'semi_annual', 'annual'])->default('monthly');
            $table->unsignedSmallInteger('billing_day')->default(1)->comment('Day of month for billing');
            $table->decimal('security_deposit', 15, 2)->default(0.00);
            $table->unsignedSmallInteger('advance_rent_months')->default(0);
            $table->decimal('escalation_rate', 5, 2)->default(0.00)->comment('Percentage');
            $table->unsignedSmallInteger('escalation_frequency_months')->default(12);
            $table->unsignedSmallInteger('payment_terms_days')->default(15)->comment('Payment due days after invoice');
            $table->enum('status', ['draft', 'active', 'expiring', 'expired', 'terminated', 'renewed'])->default('draft');
            $table->date('signed_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->text('termination_reason')->nullable();
            $table->text('special_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('lease_application_id')->references('id')->on('lease_applications')->onDelete('set null');

            // Indexes
            $table->index('property_id');
            $table->index('tenant_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
            $table->index('contract_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_contracts');
    }
};
