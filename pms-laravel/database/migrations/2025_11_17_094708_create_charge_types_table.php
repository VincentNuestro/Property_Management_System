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
        Schema::create('charge_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->enum('category', ['rent', 'utilities', 'association_dues', 'parking', 'penalty', 'deposit', 'other'])->comment('Possible values: rent, utilities, association_dues, parking, penalty, deposit, other');
            $table->boolean('is_recurring')->default(true);
            $table->boolean('is_taxable')->default(false);
            $table->decimal('default_amount', 15, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Possible values: active, inactive');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('category');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_types');
    }
};
