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
        Schema::create('lease_contract_unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_contract_id');
            $table->unsignedBigInteger('unit_id');
            $table->decimal('monthly_rent', 15, 2);
            $table->timestamp('created_at')->nullable();

            // Foreign keys
            $table->foreign('lease_contract_id')->references('id')->on('lease_contracts')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            // Unique constraint
            $table->unique(['lease_contract_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lease_contract_unit');
    }
};
