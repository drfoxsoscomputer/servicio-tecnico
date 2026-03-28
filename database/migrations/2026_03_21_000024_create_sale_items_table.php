<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->string('item_type', 20); // product, service, combo
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->unsignedBigInteger('combo_id')->nullable();
            $table->unsignedBigInteger('presentation_id')->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->foreign('combo_id')->references('id')->on('combos')->onDelete('set null');
            $table->foreign('presentation_id')->references('id')->on('product_presentations')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
