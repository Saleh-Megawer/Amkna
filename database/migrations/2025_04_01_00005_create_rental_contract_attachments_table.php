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

        Schema::create('rental_contract_attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_contract_id')
                ->constrained('rental_contracts')
                ->cascadeOnDelete();

            $table->string('file_name')->comment('اسم الملف');
            $table->string('file_path')->comment('مسار الملف');
            $table->string('extension')->nullable();

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete()
                ->comment('الموظف الذي رفع الملف');

            $table->text('notes')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_contract_attachments');

    }
};
