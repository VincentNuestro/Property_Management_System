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
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->date('penalty_date');
            $table->unsignedInteger('days_overdue');
            $table->decimal('penalty_rate', 5, 2)->comment('Percentage or flat amount');
            $table->decimal('penalty_amount', 15, 2);
            $table->boolean('is_waived')->default(false);
            $table->unsignedBigInteger('waived_by')->nullable();
            $table->timestamp('waived_at')->nullable();
            $table->text('waiver_reason')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('waived_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
