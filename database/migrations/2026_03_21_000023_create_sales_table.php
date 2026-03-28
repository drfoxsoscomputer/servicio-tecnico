<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('document_number', 20)->unique(); // ej: NTE-2026-0001 o COT-2026-0001
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20)->default('pos'); // pos, workshop
            $table->string('sale_type', 20)->default('sale'); // sale, quote
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->string('discount_type', 10)->nullable(); // none, percent, amount
            $table->decimal('discount_value', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_bs', 12, 2)->default(0);
            $table->decimal('total_usd', 12, 2)->default(0);
            $table->decimal('exchange_rate', 12, 2);
            $table->string('status', 20)->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('document_number');
            $table->index('sale_type');
            $table->index('type');
            $table->index('created_at');

            $table->foreign('ticket_id')->references('id')->on('service_tickets')->onDelete('set null');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
