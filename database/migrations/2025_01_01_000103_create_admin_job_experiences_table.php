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
        Schema::create('admin_job_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('job_title', 75);
            $table->text('job_desc');
            $table->string('company_name', 100);
            $table->mediumInteger('start_year');
            $table->mediumInteger('end_year');

            // Relation
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete("cascade")->onUpdate('cascade');

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
        Schema::dropIfExists('admin_job_experiences');
    }
};
