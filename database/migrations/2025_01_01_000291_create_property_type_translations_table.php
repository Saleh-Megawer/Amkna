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
        Schema::create('property_type_translations', function (Blueprint $table) {
            $table->id();

            // Foreign Key → property_types table
            $table->unsignedBigInteger('property_type_id');
            $table->foreign('property_type_id')
                ->references('id')
                ->on('property_types')
                ->onDelete('cascade');

            // Locale field (ar – en – etc...)
            $table->string('locale')->index();

            // Translatable fields
            $table->string('name', 150);
            $table->text('desc')->nullable(); // Optional

            // Unique constraint for locale per property type
            $table->unique(['property_type_id', 'locale']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_type_translations');
    }
};
