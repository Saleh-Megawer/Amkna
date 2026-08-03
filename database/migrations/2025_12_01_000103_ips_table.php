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
        Schema::create('ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->enum('status', ['1', '0'])->default('1')->comment("0: Blocked");

            // Relation
            $table->unsignedBigInteger('mail_id')->nullable();
            $table->foreign('mail_id')->references('id')->on('mailbox')->onDelete("set null")->onUpdate('cascade');

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
        Schema::dropIfExists('ips');
    }
};
