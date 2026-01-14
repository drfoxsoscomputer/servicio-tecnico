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
        Schema::create('service_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('old_status_id')->constrained('statuses')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('new_status_id')->constrained('statuses')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->index()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_logs');
    }
};
