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

        // جدول التصويتات
        Schema::create('owner_association_polls', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            
            $table->foreignId('owner_association_id')
                ->constrained('owner_associations')
                ->cascadeOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->comment('مفتوح أم مغلق');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_association_polls');

    }
};
