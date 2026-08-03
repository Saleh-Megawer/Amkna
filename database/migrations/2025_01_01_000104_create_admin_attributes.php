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
        Schema::create('admin_attributes', function (Blueprint $table) {
            // $table->id('id');

            // Relation
            $table->unsignedBigInteger('admin_id')->unique();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete("cascade")->onUpdate('cascade');


            $table->enum('email_verified', [1, 0])->default(0)->comment("1: The Admin Email Is verification 0: Email Not verification");
            $table->timestamp('email_verified_at')->nullable();

            // Forgot Password Attr
            $table->text('forgot_password_token')->nullable()->comment("This Unique Token For Reset Password");
            $table->string('forget_password_expiry_date',60)->nullable()->comment('Expiry Date For Reset Password Link By Unix timestamp');








            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_attributes');
    }
};
