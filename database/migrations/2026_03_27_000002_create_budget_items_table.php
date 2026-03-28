<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_id')->constrained('budgets')->cascadeOnDelete();
            $table->string('item_type', 20);
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('name', 150);
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price_bs', 12, 2)->default(0);
            $table->decimal('unit_price_usd', 12, 2)->default(0);
            $table->decimal('subtotal_bs', 12, 2)->default(0);
            $table->decimal('subtotal_usd', 12, 2)->default(0);
            $table->timestamps();

            $table->index(['budget_id']);
            $table->index(['item_type', 'item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_items');
    }
};
