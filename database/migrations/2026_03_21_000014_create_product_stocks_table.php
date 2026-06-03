<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combination_id')->nullable()->constrained('product_variant_combinations')->cascadeOnDelete();
            $table->unsignedBigInteger('presentation_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('min_stock_alert')->default(0);
            $table->string('location', 50)->nullable(); // taller, bodega, etc.
            $table->timestamp('updated_at');

            $table->foreign('presentation_id')->references('id')->on('product_presentations')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
