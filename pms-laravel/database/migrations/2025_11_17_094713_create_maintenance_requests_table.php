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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('request_number', 100)->unique();
            $table->string('title', 255);
            $table->text('description');
            $table->string('category', 100)->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->comment('Possible values: low, medium, high, urgent');
            $table->enum('status', ['submitted', 'acknowledged', 'assigned', 'in_progress', 'completed', 'cancelled'])->default('submitted')->comment('Possible values: submitted, acknowledged, assigned, in_progress, completed, cancelled');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');

            // Indexes
            $table->index('property_id');
            $table->index('unit_id');
            $table->index('status');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
