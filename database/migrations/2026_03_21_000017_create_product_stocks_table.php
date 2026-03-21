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
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->foreignId('presentation_id')->nullable()->constrained('product_presentations')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('min_stock_alert')->default(0)->comment('Alerta cuando baje de este número');
            $table->timestamps();
            
            $table->unique(['product_id', 'variant_id', 'presentation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
