<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('interests', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();

            // من هو العميل؟
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            // هل الاهتمام مرتبط بعقار؟
            $table->foreignId('property_id')->nullable()->constrained('properties')->nullOnDelete();

            // نوع الاهتمام
            $table->string('type')->default('property')
                ->comment('interest type: property, general, project, service, etc.');

            // بيانات إضافية من العميل
            $table->text('message')->nullable();

            // الموظف المكلّف بالمتابعة
            $table->foreignId('assigned_to')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();

            // حالة الـ lead
            $table->string('status')->default('new')
                ->comment('new, assigned, contacted, in_progress, converted, not_interested, closed');

            $table->boolean('is_read')->default(false)->comment('0 = not seen, 1 = seen by admin');

            $table->timestamps();

            $table->index('created_at');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interests');
    }
};
