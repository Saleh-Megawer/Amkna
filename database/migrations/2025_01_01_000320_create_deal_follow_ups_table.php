<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained('deals')->cascadeOnDelete();
            
            // نوع المتابعة
            $table->string('follow_up_type', 50)->default('call')
                  ->comment('call, visit, send_offer, meeting, email, other');
            
            // الموعد المجدول
            $table->dateTime('scheduled_at')->comment('تاريخ ووقت المتابعة المجدولة');
            
            // الحالة
            $table->string('status', 50)->default('pending')
                  ->comment('حالة المتابعة: pending, completed, cancelled, overdue');
            
            // الأولوية
            $table->string('priority', 50)->default('normal')
                  ->comment('أولوية المتابعة: low, normal, high, urgent');
            
            // المسؤول عن المتابعة
            $table->foreignId('assigned_to')->nullable()->constrained('admins')->nullOnDelete()
                  ->comment('الموظف المسؤول عن المتابعة');
            
            // ملاحظات
            $table->text('notes')->nullable()->comment('ملاحظات عن المتابعة');
            
            // تاريخ التنفيذ الفعلي
            $table->dateTime('completed_at')->nullable()->comment('تاريخ ووقت التنفيذ الفعلي');
            
            // من أنشأ المتابعة
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['deal_id', 'status', 'scheduled_at']);
            $table->index(['assigned_to', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_follow_ups');
    }
};
