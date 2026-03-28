<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_status_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('service_tickets')->cascadeOnDelete();
            $table->unsignedBigInteger('old_status_id')->nullable();
            $table->unsignedBigInteger('new_status_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('created_at');

            $table->foreign('old_status_id')->references('id')->on('workshop_statuses')->onDelete('set null');
            $table->foreign('new_status_id')->references('id')->on('workshop_statuses')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_status_logs');
    }
};
