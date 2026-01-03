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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('client_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('type_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('brand_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('model', 100)->nullable();
            $table->string('serial', 100)->nullable();
            $table->string('access_password', 150)->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
