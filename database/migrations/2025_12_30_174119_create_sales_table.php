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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('type',20)->default('sale'); // sale (venta directa), service (sericio tecnico/reparación)
            $table->decimal('net_amount', 10,2)->default(0.00); // base sin impuesto
            $table->string('discount_type', 10)->default('none'); //none (sin descuento), percent (porcentaje %), amount (monto)
            $table->decimal('discount_value', 10,2)->default(0.00); // porcentaje o monto ingresado
            $table->decimal('discount_amount', 10,2)->default(0.00); //monto de descuento calculado
            $table->decimal('tax_percentage', 5,2)->default(0.00); // % IVA aplicado
            $table->decimal('tax_amount', 10,2)->default(0.00); //monto de IVA
            $table->decimal('total_amount', 10,2); //total con impuesto
            $table->string('status', 20)->default('paid'); // pending, paid, canceled...
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
