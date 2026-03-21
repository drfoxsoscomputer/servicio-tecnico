<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('restrict');
            $table->string('type', 50)->comment('Teléfono, Laptop, Tablet, etc.');
            $table->string('model', 100);
            $table->string('serial', 100)->nullable()->comment('IMEI, número de serie');
            $table->string('access_password', 150)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('serial');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
