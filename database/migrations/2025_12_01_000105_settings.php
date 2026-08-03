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
        Schema::create('settings', function (Blueprint $table) {

            // Main
            $table->id();
            $table->string('logo', 150)->nullable();
            $table->string('footer_logo', 150)->nullable();
            // $table->string('logo_size', 50)->nullable();

            // $table->string('address')->nullable();
            $table->text('google_map_address_embed')->nullable();

            //  $table->string('website_name', 100)->nullable(); // IN About Table
            // $table->string('website_icon', 100)->nullable();
            //  $table->text('website_desc')->nullable(); // IN About Table

            //contact
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();

            // Social
            $table->string('facebook')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('telegram')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('linkedin')->nullable();
            // $table->string('github')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
