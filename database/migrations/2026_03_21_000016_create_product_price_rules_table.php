<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_price_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->integer('min_quantity')->comment('Cantidad mínima');
            $table->integer('max_quantity')->nullable()->comment('Cantidad máxima');
            $table->string('price_type', 10)->comment('fixed, percent');
            $table->decimal('price_value', 12, 2)->comment('Valor del descuento');
            $table->string('currency', 10)->default('Bs');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['product_id', 'min_quantity']);
            $table->index(['category_id', 'min_quantity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_price_rules');
    }
};
