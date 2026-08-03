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
        Schema::create('neighborhoods_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('desc')->nullable();

            $table->unsignedBigInteger('neighborhood_id');
            $table->string('locale')->index();
            $table->unique(['neighborhood_id', 'locale']);
            $table->foreign('neighborhood_id')->references('id')->on('neighborhoods')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('neighborhoods_translations');
    }
};
