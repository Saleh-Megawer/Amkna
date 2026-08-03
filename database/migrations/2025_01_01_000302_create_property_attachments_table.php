<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('attachment_name',100); // 
            $table->string('extension',30); // 
            $table->string('type',30); // 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_attachments');
    }
};
