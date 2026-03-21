<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshop_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 50)->unique()->comment('recibido, diagnosticando, esperando_aprobacion, etc.');
            $table->string('color', 20);
            $table->text('description')->nullable();
            $table->boolean('is_final')->default(false)->comment('si es estado final');
            $table->string('notify_role', 50)->nullable()->comment('tecnico, recepcionista');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_statuses');
    }
};
