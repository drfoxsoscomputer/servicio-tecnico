<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 20)->unique()->comment('Ej: TKT-2026-0001');
            $table->foreignId('device_id')->constrained('devices')->onDelete('restrict');
            $table->foreignId('client_id')->constrained('clients')->onDelete('restrict');
            $table->foreignId('workshop_status_id')->default(1)->constrained('workshop_statuses')->onDelete('restrict');
            $table->foreignId('received_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('technician_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title', 150)->comment('Nombre corto del problema');
            $table->text('problem_reported')->comment('Problema reportado por el cliente');
            $table->text('diagnosis')->nullable()->comment('Diagnóstico del técnico');
            $table->decimal('estimated_price', 12, 2)->nullable()->comment('Precio estimado');
            $table->decimal('final_price', 12, 2)->nullable()->comment('Precio final');
            $table->text('work_done')->nullable()->comment('Trabajo realizado');
            $table->dateTime('delivered_at')->nullable()->comment('Fecha de entrega');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('ticket_number');
            $table->index('workshop_status_id');
            $table->index('technician_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_tickets');
    }
};
