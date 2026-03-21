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
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->string('sku', 100)->nullable()->comment('Código interno');
            $table->string('barcode', 100)->nullable()->comment('Código de barras');
            $table->decimal('price_bs', 12, 2)->comment('Precio unitario en Bs');
            $table->decimal('price_usd', 12, 2)->comment('Precio unitario en USD');
            $table->boolean('has_variants')->default(false)->comment('Si tiene variantes (color, etc.)');
            $table->boolean('has_inventory')->default(true)->comment('Si maneja stock');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique('sku');
            $table->unique('barcode');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
