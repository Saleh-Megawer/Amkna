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
        Schema::create('about_translations', function (Blueprint $table) {
            $table->id();

            $table->string('header_title')->nullable();
            $table->text('header_desc')->nullable();

            // للحقول اللي هتخزن JSON كبير
            $table->longText('our_journey')->nullable();
            $table->longText('vision')->nullable();
            $table->longText('about')->nullable();
            $table->longText('our_core_values')->nullable();
            $table->longText('why_us')->nullable();

            $table->unsignedBigInteger('about_id');
            $table->string('locale')->index();
            $table->unique(['about_id', 'locale']);
            $table->foreign('about_id')->references('id')->on('abouts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_translations');
    }
};
