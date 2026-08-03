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
        Schema::create('privacy_translations', function (Blueprint $table) {
            $table->id();

            $table->longText('desc');

            $table->unsignedBigInteger('privacy_id');
            $table->string('locale')->index();

            $table->unique(['privacy_id', 'locale']);
            $table->foreign('privacy_id')->references('id')->on('privacies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('privacy_translations');
    }
};
