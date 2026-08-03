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
        Schema::create('admins', function (Blueprint $table) {

            $table->id();

            // Personal Data
            $table->string('f_name', 40);
            $table->string('l_name', 40);
            $table->string('full_name', 120);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->unique()->nullable();
            $table->text('about')->nullable();
            $table->string('country', 75)->nullable();
            $table->string('city', 75)->nullable();
            $table->string('zip_code', 75)->nullable();
            $table->text('skills')->nullable();
            $table->string('job')->nullable();

            //
            $table->enum('type', ['admin', 'sales'])->default('admin');
            //
            $table->string('marketing_license')->nullable();
            $table->boolean('is_marketer_request')->default(false);

            // Only applies if user type is 'sales'
            // Determines whether the system can assign leads/customers to this user
            $table->boolean('is_available')
                ->default(false)
                ->comment('Only for sales users: determines if the system can assign leads/customers to this user');

            // Media
            $table->string('avatar', 100)->nullable();
            $table->string('cover', 100)->nullable();

            // Dashboard Settings For This Admin
            $table->unsignedBigInteger('language')->nullable();
            $table->foreign('language')->references("id")->on('languages')->onDelete('set null')->onUpdate('cascade');
            $table->string('theme')->default('light');

            // Other
            $table->timestamp('last_seen')->nullable();
            $table->enum('status', [1, 0])->default(1)->comment("If the account is banned, the value will be 0");

            $table->date('joining_date')->default(date('Y-m-d'));

            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
