<?php

use App\Models\Dashboard\Admin;
use App\Models\Dashboard\Mailbox;
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

        Schema::create('mail_replies', function (Blueprint $table) {


            // Get mailbox Table Name
            $mailTable = new Mailbox();
            $mailTable = $mailTable->table;
            $table->id();
            $table->longText('subject');
            $table->longText('message');
            $table->unsignedBigInteger('mail');
            $table->foreign('mail')->on($mailTable)->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('reply_by');
            $table->foreign('reply_by')->on('admins')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('mail_replies');
    }
};
