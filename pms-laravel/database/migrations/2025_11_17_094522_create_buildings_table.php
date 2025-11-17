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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('code', 50);
            $table->string('name');
            $table->unsignedInteger('total_floors')->default(0);
            $table->text('description')->nullable();
            $table->string('status', 20)->default('active'); // enum: active, inactive
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['property_id', 'code']);
            $table->index('property_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
