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
        Schema::create('mailbox', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from')->nullable()->comment('Get this from " emails " tabel');
            $table->foreign('from')->on('emails')->references('id')->onDelete('set null')->onUpdate('cascade');
            $table->string('phone')->nullable();
            $table->string('name');
            $table->string('subject');
            $table->text('message');
            $table->string('attach_file')->nullable();
            $table->enum('read', [1, 0])->default(0)->comment("1 : This Mail Is Read");
            $table->integer('unix_time');
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
        Schema::dropIfExists('mailbox');
    }
};
