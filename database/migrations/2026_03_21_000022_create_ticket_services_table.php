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
            $table->foreignId('ticket_id')->constrained('service_tickets')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('restrict');
            $table->decimal('price', 12, 2)->comment('Precio aplicado al ticket');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['ticket_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_services');
    }
};
