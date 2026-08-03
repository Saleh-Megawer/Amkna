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
        Schema::create('property_amenity_translations', function (Blueprint $table) {
            $table->id();

            // Foreign key to the main table
            $table->foreignId('property_amenity_id')->constrained()->cascadeOnDelete();

            // Locale column for the translation (ar, en, etc.)
            $table->string('locale')->index();

            // Translatable fields
            $table->string('name', 100);

            // Unique combination
            $table->unique(['property_amenity_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_amenity_translations');
    }
};
