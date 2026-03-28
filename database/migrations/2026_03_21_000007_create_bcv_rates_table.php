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
            $table->decimal('rate', 12, 2);
            $table->string('source', 50)->default('BCV');
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bcv_rates');
    }
};
