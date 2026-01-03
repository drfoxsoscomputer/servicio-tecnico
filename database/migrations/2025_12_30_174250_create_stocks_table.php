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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete(); //movimiento ligado a servicio
            $table->foreignId('sale_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete(); //movimiento ligado a la venta
            $table->string('type', 20); //in, out, adjust (entrada, salida, ajuste)
            $table->integer('quantity')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
