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
        Schema::create('faqs_translations', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->string('desc');

            $table->unsignedBigInteger('faqs_id');
            $table->string('locale')->index();

            $table->unique(['faqs_id', 'locale']);
            $table->foreign('faqs_id')->references('id')->on('faqs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs_translations');
    }
};
