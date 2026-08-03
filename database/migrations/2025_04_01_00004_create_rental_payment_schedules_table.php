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

        Schema::create('rental_payment_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_contract_id')
                ->constrained('rental_contracts')
                ->cascadeOnDelete();

            $table->unsignedInteger('payment_number')->comment('رقم الدفعة: 1, 2, 3...');
            $table->date('due_date')->comment('تاريخ الاستحقاق');
            $table->unsignedInteger('amount')->comment('مبلغ الدفعة');

            $table->string('status')->default('pending')->comment('pending, paid, overdue, cancelled');
            $table->timestamp('paid_at')->nullable()->comment('تاريخ الدفع الفعلي');

            // Link to financial transaction
            $table->foreignId('payment_reference')
                ->nullable()
                ->constrained('financial_transactions')
                ->nullOnDelete()
                ->comment('ربط بالمعاملة المالية في حالة الدفع');

            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['rental_contract_id', 'status']);
            $table->unique(['rental_contract_id', 'due_date']);
            $table->index('due_date');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_payment_schedules');

    }
};
