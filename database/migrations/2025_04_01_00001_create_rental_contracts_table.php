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

        Schema::create('rental_contracts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();

            // Contract Information
            $table->string('contract_number')->unique()->comment('رقم العقد - يتولد تلقائياً مثل RC-2026-0001');

            $table->string('deed_number', 100)->unique()->nullable('Property deed number');

            $table->date('start_date')->comment('تاريخ بداية العقد');
            $table->date('end_date')->comment('تاريخ نهاية العقد');

            // Financial Information
            $table->unsignedInteger('total_rent_amount')->comment('إجمالي الإيجار المتفق عليه');
            $table->string('payment_frequency')->comment('نظام الدفع: daily, monthly, yearly');
            $table->unsignedInteger('expected_payment_amount')->comment('قيمة الدفعة الواحدة المتوقعة');

            // Property Relation (nullable للحالة الثانية)
            $table->foreignId('property_id')
                ->nullable()
                ->constrained('properties')
                ->nullOnDelete()
                ->comment('العقار المرتبط - nullable للتأجيرات المستقلة');

            // Parties (Owner & Tenant)
            $table->foreignId('owner_client_id')
                ->constrained('clients')
                ->cascadeOnDelete()
                ->comment('المالك');

            $table->foreignId('tenant_client_id')
                ->constrained('clients')
                ->cascadeOnDelete()
                ->comment('المستأجر');

            // Deposit (التأمين)
            $table->unsignedInteger('deposit_amount')->default(0)->comment('مبلغ التأمين');
            $table->string('deposit_status')->default('pending')->comment('pending, paid, refunded, deducted');
            $table->timestamp('deposit_paid_at')->nullable()->comment('تاريخ دفع التأمين');

            // Commission (العمولة)
            $table->unsignedInteger('commission_amount')->default(0)->comment('عمولة الشركة');
            $table->string('commission_status')->default('pending')->comment('pending, collected');
            $table->timestamp('commission_collected_at')->nullable()->comment('تاريخ تحصيل العمولة');

            // Status
            $table->string('status')->default('draft')->comment('draft, active, expired, terminated, cancelled');

            // Closure Information
            $table->date('closure_date')->nullable()->comment('تاريخ التقفيل');
            $table->text('closure_notes')->nullable()->comment('ملاحظات التقفيل');

            // Admin & Notes
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete()
                ->comment('الموظف المسؤول');

            $table->text('notes')->nullable()->comment('ملاحظات عامة');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['owner_client_id', 'tenant_client_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_contracts');

    }
};
