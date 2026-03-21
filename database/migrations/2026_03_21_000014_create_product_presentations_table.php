<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name', 50)->comment('Caja, Docena, Unidad');
            $table->integer('units_per_presentation')->default(1)->comment('Cuántas unidades tiene');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            
            $table->unique(['product_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_presentations');
    }
};
