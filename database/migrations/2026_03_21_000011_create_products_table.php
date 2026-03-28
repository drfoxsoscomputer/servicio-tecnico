<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('sku', 100)->nullable()->unique();
            $table->string('barcode', 100)->nullable()->unique();
            $table->decimal('price_bs', 12, 2); // Precio unitario en Bs
            $table->decimal('price_usd', 12, 2); // Precio unitario en USD
            $table->boolean('has_variants')->default(false); // Si tiene variantes (color, etc.)
            $table->boolean('has_inventory')->default(true); // Si maneja stock
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
