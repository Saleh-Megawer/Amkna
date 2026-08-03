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

        Schema::create('owner_association_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // العلاقات الأساسية
            $table->foreignId('owner_association_id')
                ->constrained('owner_associations')
                ->cascadeOnDelete();

            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('owner_association_units')
                ->nullOnDelete()
                ->comment('الوحدة المرتبطة (اختياري)');

            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete()
                ->comment('العميل مقدم الطلب');

            // نوع الطلب
            $table->string('type')->comment('نوع الطلب');
            // [
            //     'report',      // بلاغ
            //     'complaint',   // شكوى
            //     'maintenance', // صيانة
            //     'service',     // طلب خدمة
            //     'suggestion',  // اقتراح
            //     'inquiry',     // استفسار
            //     'emergency',   // طارئ
            //     'general',     // عام
            // ]

                                                     // تفاصيل الطلب
            $table->string('title');                 // الموضوع
            $table->text('description')->nullable(); // الوصف

            // الأولوية
            $table->string('priority')->default('normal')->comment('الأولوية');

            
            // ['low', 'medium', 'high', 'urgent']

            // الحالة
            $table->string('status')->default('pending');

            // [
            //     'pending',      // قيد الانتظار
            //     'under_review', // قيد المراجعة
            //     'in_progress',  // قيد التنفيذ
            //     'completed',    // مكتمل
            //     'closed',       // مغلق
            //     'rejected',     // مرفوض
            //     'cancelled',    // ملغي
            // ]

            // الموظف المسؤول
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete()
                ->comment('الموظف المكلف');

            // ملاحظات
            $table->text('admin_notes')->nullable()->comment('ملاحظات الإدارة');
            $table->text('rejection_reason')->nullable()->comment('سبب الرفض');

            // تواريخ مهمة
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(
                ['owner_association_id', 'status', 'type'],
                'oa_requests_oa_status_type_idx'
            );

            $table->index(
                ['client_id', 'status'],
                'oa_requests_client_status_idx'
            );

            $table->index(
                'created_at',
                'oa_requests_created_at_idx'
            );

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_association_requests');
    }
};
