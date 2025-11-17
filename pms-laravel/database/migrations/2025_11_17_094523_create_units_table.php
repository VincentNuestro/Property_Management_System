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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('building_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('floor_id')->nullable()->constrained()->onDelete('set null');
            $table->string('unit_code', 100)->unique();
            $table->string('unit_number', 100);
            $table->string('type'); // enum: commercial, office, residential, parking, storage, kiosk
            $table->string('classification', 100)->nullable();
            $table->decimal('area_sqm', 10, 2)->nullable();
            $table->unsignedInteger('bedrooms')->default(0);
            $table->unsignedInteger('bathrooms')->default(0);
            $table->string('status', 20)->default('vacant'); // enum: vacant, occupied, reserved, maintenance, unavailable
            $table->decimal('base_rent', 15, 2)->default(0);
            $table->decimal('association_dues', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('property_id');
            $table->index('building_id');
            $table->index('floor_id');
            $table->index('status');
            $table->index('type');
            $table->index('unit_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
