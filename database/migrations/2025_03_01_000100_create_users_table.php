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
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('name', 100);
            $table->string('email')->unique();
            $table->string('phone_country_code', 75);
            $table->string('phone', 75);

            $table->string('password', 150);

            $table->string('avatar', 100)->nullable();

            $table->enum('status', [1, 0])->default(1)->comment("If the account is banned, the value will be 0");
            $table->enum('email_verified_at', ['1', '0'])->default('0')->comment('1: is verified');
            $table->timestamp('last_seen')->nullable();


            // Forgot Password Attr
            $table->text('forgot_password_token')->nullable()->comment("This Unique Token For Reset Password");
            $table->string('forget_password_expiry_date', 60)->nullable()->comment('Expiry Date For Reset Password Link By Unix timestamp');

            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
