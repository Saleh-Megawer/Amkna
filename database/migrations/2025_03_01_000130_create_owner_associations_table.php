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
        Schema::create('owner_associations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name'); // اسم اتحاد الملاك / العقار
            $table->text('address')->nullable(); // اسم اتحاد الملاك / العقار
            
            $table->foreignId('manager_client_id')->nullable()->constrained('clients')->nullOnDelete()->comment('The client responsible for the owner associations');
            // Admin
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_associations');
    }
};
