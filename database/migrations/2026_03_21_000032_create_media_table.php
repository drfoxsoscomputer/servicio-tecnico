<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('collection_name', 255)->nullable();
            $table->string('file_name', 255);
            $table->string('mime_type', 255);
            $table->integer('size');
            $table->string('path', 255);
            $table->timestamp('created_at');

            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
