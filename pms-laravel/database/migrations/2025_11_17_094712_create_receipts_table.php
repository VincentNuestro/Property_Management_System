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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_id');
            $table->string('receipt_number', 100)->unique();
            $table->date('receipt_date');
            $table->decimal('amount', 15, 2);
            $table->unsignedBigInteger('issued_by')->nullable();
            $table->timestamp('printed_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('payment_id');
            $table->index('receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
