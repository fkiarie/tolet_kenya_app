<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();

            // Payment fields
            $table->date('payment_date')->nullable(); // Set in controller
            $table->string('month_for')->index(); // Format: '2025-07'
            $table->decimal('amount', 10, 2); // Paid by tenant
            $table->decimal('commission_amount', 10, 2); // Entered by admin
            $table->decimal('commission_rate', 5, 2)->nullable(); // Auto-calculated
            $table->decimal('landlord_amount', 10, 2); // amount - commission

            // Metadata
            $table->string('method'); // M-Pesa, Cash, etc.
            $table->string('reference')->nullable(); // Transaction code
            $table->enum('status', ['paid', 'pending', 'failed'])->default('paid');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
