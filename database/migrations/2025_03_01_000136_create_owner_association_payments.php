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

        Schema::create('owner_association_payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // ربط بالطلب
            $table->foreignId('request_id')->constrained('owner_association_requests')->cascadeOnDelete();

            // بيانات التحقق (يملأها الموظف)
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->date('subscription_from')->nullable();
            $table->date('subscription_to')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();

            // الموظف المسؤول
            $table->foreignId('verified_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_association_payments');

    }
};
