<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('service_tickets')->cascadeOnDelete();
            $table->unsignedBigInteger('service_id')->nullable(); // null si es servicio único temporal
            $table->string('custom_service_name', 150)->nullable(); // solo si service_id es null
            $table->string('location_type', 20); // workshop, home
            $table->decimal('price', 12, 2);
            $table->string('discount_type', 10)->nullable(); // percentage, fixed
            $table->decimal('discount_value', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->text('discount_note')->nullable(); // nota interna para auditoría
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_services');
    }
};
