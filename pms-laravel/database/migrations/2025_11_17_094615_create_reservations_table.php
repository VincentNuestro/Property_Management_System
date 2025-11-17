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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reservation_number', 100)->unique();
            $table->date('reservation_date');
            $table->decimal('reservation_fee', 15, 2)->default(0);
            $table->decimal('reservation_paid', 15, 2)->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('status', 20)->default('active'); // enum: active, converted, cancelled, expired
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('property_id');
            $table->index('unit_id');
            $table->index('tenant_id');
            $table->index('status');
            $table->index('reservation_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
