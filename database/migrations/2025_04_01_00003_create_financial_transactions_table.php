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

        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // Polymorphic Relation
            $table->morphs('transactionable', 'txn_morph_idx');

            // Transaction Type
            $table->string('type')->comment('expense, revenue');

            $table->string('category')->comment('rent_payment, maintenance, electricity, water, commission, deposit_refund, etc.');

            // Financial Details
            $table->unsignedInteger('amount')->comment('المبلغ');
            $table->date('transaction_date')->comment('تاريخ المعاملة');
            $table->text('description')->nullable()->comment('الوصف');

            // Payment Information
            $table->string('payment_method')->nullable()->comment('cash, bank_transfer, check, card');
            $table->string('receipt_number')->nullable()->comment('رقم الإيصال/الفاتورة');

            $table->string('status')->default('pending')->comment('pending, paid, cancelled');

            // Parties
            $table->foreignId('paid_by')
                ->nullable()
                ->constrained('clients')
                ->nullOnDelete()
                ->comment('من دفع (للمصروفات)');

            $table->foreignId('received_from')
                ->nullable()
                ->constrained('clients')
                ->nullOnDelete()
                ->comment('من استلم منه (للإيرادات)');

            // Admin
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete()
                ->comment('الموظف الذي سجل المعاملة');

            $table->timestamps();

            // Indexes
            $table->index(['type', 'status']);
            $table->index('transaction_date');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');

    }
};
