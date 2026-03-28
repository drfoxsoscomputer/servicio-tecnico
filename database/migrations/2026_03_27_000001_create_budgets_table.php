<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('budget_number', 20)->unique();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('customer_name', 150)->nullable();
            $table->string('customer_phone', 50)->nullable();
            $table->decimal('subtotal_bs', 12, 2)->default(0);
            $table->decimal('subtotal_usd', 12, 2)->default(0);
            $table->decimal('exchange_rate', 12, 2)->default(0);
            $table->decimal('total_bs', 12, 2)->default(0);
            $table->enum('status', ['draft', 'confirmed', 'printed'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamp('printed_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index('budget_number');
            $table->index('status');
            $table->index(['created_by', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
