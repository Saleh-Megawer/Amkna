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

        Schema::create('owner_association_request_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')
                ->constrained('owner_association_requests')
                ->cascadeOnDelete();
            // من كتب الرد (client أو admin)
            $table->morphs('replier');
            $table->text('message');
            // نوع الرد
            $table->enum('type', [
                'comment',       // تعليق
                'update',        // تحديث
                'status_change', // تغيير حالة
                'internal',      // ملاحظة داخلية
            ])->default('comment');
            $table->boolean('is_internal')->default(false)->comment('ظاهر للإدارة فقط');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_association_request_replies');
    }
};

// // الموظف يغير الحالة من "pending" إلى "in_progress"
// $request->update(['status' => 'in_progress']);

// // النظام تلقائياً يضيف رد في الجدول:
// Reply::create([
//     'request_id'   => $request->id,
//     'replier_type' => 'App\Models\Admin',
//     'replier_id'   => auth()->id(),
//     'message'      => 'تم تغيير الحالة من "قيد الانتظار" إلى "قيد التنفيذ"',
//     'type'         => 'status_change', // ✅ هنا
//     'is_internal'  => false
