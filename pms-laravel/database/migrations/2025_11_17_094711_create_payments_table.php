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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('payment_number', 100)->unique();
            $table->date('payment_date');
            $table->enum('payment_method', ['cash', 'check', 'bank_transfer', 'credit_card', 'online', 'pdc'])->comment('Possible values: cash, check, bank_transfer, credit_card, online, pdc');
            $table->decimal('amount', 15, 2);
            $table->decimal('applied_amount', 15, 2)->default(0.00)->comment('Amount applied to invoices');
            $table->decimal('unapplied_amount', 15, 2)->default(0.00)->comment('Overpayment/credit');
            $table->string('reference_number', 255)->nullable();
            $table->string('check_number', 100)->nullable();
            $table->date('check_date')->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->timestamp('deposited_at')->nullable();
            $table->enum('status', ['pending', 'cleared', 'bounced', 'cancelled'])->default('pending')->comment('Possible values: pending, cleared, bounced, cancelled');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('received_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('property_id');
            $table->index('tenant_id');
            $table->index('payment_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
