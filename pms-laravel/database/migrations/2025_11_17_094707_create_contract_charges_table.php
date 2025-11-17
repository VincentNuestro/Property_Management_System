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
        Schema::create('contract_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_contract_id');
            $table->unsignedBigInteger('charge_type_id');
            $table->decimal('amount', 15, 2);
            $table->boolean('is_recurring')->default(true);
            $table->enum('frequency', ['one_time', 'monthly', 'quarterly', 'annual'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('lease_contract_id')->references('id')->on('lease_contracts')->onDelete('cascade');
            $table->foreign('charge_type_id')->references('id')->on('charge_types')->onDelete('cascade');

            // Indexes
            $table->index('lease_contract_id');
            $table->index('charge_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_charges');
    }
};
