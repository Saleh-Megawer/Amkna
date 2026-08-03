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

        // جدول الأصوات
        Schema::create('owner_association_poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')
                ->constrained('owner_association_polls')
                ->cascadeOnDelete();
                
            $table->foreignId('client_id')
                ->constrained('clients')
                ->cascadeOnDelete();

            $table->enum('vote', ['yes', 'no'])->comment('نعم أو لا');
            $table->text('notes')->nullable()->comment('ملاحظات العميل');

            $table->timestamps();

            // عميل واحد يصوت مرة واحدة فقط في كل تصويت
            $table->unique(['poll_id', 'client_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_association_poll_votes');

    }
};
