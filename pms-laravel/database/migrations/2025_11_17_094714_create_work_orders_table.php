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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('maintenance_request_id')->nullable();
            $table->string('work_order_number', 100)->unique();
            $table->string('title', 255);
            $table->text('description');
            $table->string('category', 100)->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->comment('Possible values: low, medium, high, urgent');
            $table->enum('type', ['preventive', 'corrective', 'emergency', 'project'])->default('corrective')->comment('Possible values: preventive, corrective, emergency, project');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->date('scheduled_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'in_progress', 'on_hold', 'completed', 'cancelled'])->default('draft')->comment('Possible values: draft, scheduled, in_progress, on_hold, completed, cancelled');
            $table->decimal('estimated_cost', 15, 2)->default(0.00);
            $table->decimal('actual_cost', 15, 2)->default(0.00);
            $table->boolean('is_billable')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('maintenance_request_id')->references('id')->on('maintenance_requests')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('property_id');
            $table->index('assigned_to');
            $table->index('status');
            $table->index(['scheduled_date', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
