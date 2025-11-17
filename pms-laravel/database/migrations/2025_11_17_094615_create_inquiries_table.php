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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('inquiry_number', 100)->unique();
            $table->string('inquirer_name');
            $table->string('inquirer_email')->nullable();
            $table->string('inquirer_phone', 50)->nullable();
            $table->string('company_name')->nullable();
            $table->string('space_type', 100)->nullable();
            $table->decimal('desired_area_sqm', 10, 2)->nullable();
            $table->date('desired_move_in_date')->nullable();
            $table->decimal('budget_min', 15, 2)->nullable();
            $table->decimal('budget_max', 15, 2)->nullable();
            $table->string('source', 100)->nullable(); // walk-in, website, referral, etc.
            $table->string('status', 20)->default('new'); // enum: new, contacted, qualified, proposal_sent, won, lost
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('property_id');
            $table->index('status');
            $table->index('inquiry_number');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
