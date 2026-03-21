<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('price_bs', 12, 2)->default(0)->comment('Precio en Bs');
            $table->decimal('price_usd', 12, 2)->default(0)->comment('Precio en USD');
            $table->decimal('margin_percent', 5, 2)->nullable()->comment('Margen de ganancia %');
            $table->timestamps();
            
            $table->unique('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
