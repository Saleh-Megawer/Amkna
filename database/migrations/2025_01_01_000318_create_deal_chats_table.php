<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained('deals')->cascadeOnDelete();
            
            // نوع التواصل
            $table->string('contact_type', 50)->default('call')
                  ->comment('call, whatsapp, meeting, email, other');
            
            // تاريخ ووقت التواصل
            $table->dateTime('contacted_at')->comment('تاريخ ووقت التواصل');
            
            // مدة المكالمة بالدقائق (اختياري)
            $table->integer('duration')->nullable()->comment('مدة التواصل بالدقائق');
            
            // محتوى المحادثة/الملاحظات
            $table->text('notes')->nullable()->comment('محتوى المحادثة أو الملاحظات');
            
            // نتيجة المحادثة
            $table->string('outcome', 50)->nullable()
                  ->comment('نتيجة المحادثة: positive, negative, neutral');
            
            // الإجراء التالي المطلوب
            $table->text('next_action')->nullable()->comment('الإجراء المطلوب بعد المحادثة');
            
            // من قام بالتواصل
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['deal_id', 'contacted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_chats');
    }
};
