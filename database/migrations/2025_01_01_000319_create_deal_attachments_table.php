<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deal_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained('deals')->cascadeOnDelete();

            // نوع المرفق
            $table->string('attachment_type', 50)->default('other')
                ->comment('contract, invoice, image, document, id_card, other');

            // بيانات الملف
            $table->string('file_name')->comment('اسم الملف الأصلي');
            $table->string('file_path')->comment('مسار الملف');
            $table->unsignedBigInteger('file_size')->nullable()->comment('حجم الملف بالبايت');
            $table->string('mime_type', 100)->nullable()->comment('نوع الملف');
            $table->string('extension', 30)->nullable();

            // ملاحظات عن المرفق
            $table->text('notes')->nullable()->comment('ملاحظات عن المرفق');

            // من قام بالرفع
            $table->foreignId('uploaded_by')->nullable()->constrained('admins')->nullOnDelete();

            $table->timestamps();

            // Indexes
            $table->index(['deal_id', 'attachment_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_attachments');
    }
};
