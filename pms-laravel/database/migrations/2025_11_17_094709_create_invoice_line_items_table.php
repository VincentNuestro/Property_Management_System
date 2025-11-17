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
        Schema::create('invoice_line_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('charge_type_id');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('description', 255);
            $table->decimal('quantity', 10, 2)->default(1.00);
            $table->decimal('unit_price', 15, 2);
            $table->decimal('amount', 15, 2);
            $table->boolean('is_taxable')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('charge_type_id')->references('id')->on('charge_types')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');

            // Indexes
            $table->index('invoice_id');
            $table->index('charge_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_line_items');
    }
};
