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
            $table->string('ticket_number', 20)->unique(); // ej: TKT-2026-0001
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('client_id'); // copia para referencia rápida
            $table->foreignId('workshop_status_id')->constrained()->cascadeOnDelete();
            $table->foreignId('received_by')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->string('title', 150);
            $table->text('problem_reported');
            $table->text('diagnosis')->nullable();
            $table->decimal('estimated_price', 12, 2)->nullable();
            $table->decimal('final_price', 12, 2)->nullable();
            $table->text('work_done')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('technician_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_tickets');
    }
};
