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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_attribute_id')->constrained('variant_attributes')->cascadeOnDelete();
            $table->string('name', 100); // Samsung, Kingston, 256GB
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['variant_attribute_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
