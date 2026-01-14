<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('payment_method_id')->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->text('note')->nullable(); //referencia, banco, observaciones...
            $table->decimal('amount', 10, 2);
            $table->dateTime('paid_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
