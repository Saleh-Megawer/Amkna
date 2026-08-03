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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);             // اسم الحالة بالعربي
            $table->string('slug', 100)->unique();   // الاسم المختصر (new, contacted...)
            $table->string('type', 50);              // يحدد النوع (client, property, lead, invoice...)
            $table->string('color', 20)->nullable(); // لون الحالة للعرض
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
