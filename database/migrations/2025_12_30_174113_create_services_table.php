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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('status_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();;
            $table->foreignId('received_by')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('technician_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('closed_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->text('problem_reported');
            $table->text('diagnosis')->nullable();
            $table->string('title', 150)->nullable()->nullable(); //nombre corto del servicio
            $table->text('work_done')->nullable();
            $table->decimal('price_service', 10, 2)->default(0.00);
            $table->dateTime('delivered_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
