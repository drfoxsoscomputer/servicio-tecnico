<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->decimal('amount_usd', 12, 2)->nullable();
            $table->string('reference', 100)->nullable();
            $table->dateTime('paid_at');
            $table->timestamps();

            $table->index('sale_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_payments');
    }
};
