<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('purchase_requests')->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable(); // null si es producto nuevo
            $table->string('product_name', 150);
            $table->integer('quantity_needed');
            $table->integer('times_requested')->default(1);
            $table->decimal('supplier_price', 12, 2)->nullable();
            $table->timestamp('last_request_at')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
