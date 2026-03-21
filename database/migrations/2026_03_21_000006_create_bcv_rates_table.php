<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bcv_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('rate', 12, 2)->comment('precio del dólar en Bs');
            $table->string('source', 50)->default('BCV')->comment('BCV, Paralelo, Personalizado');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('recorded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bcv_rates');
    }
};
