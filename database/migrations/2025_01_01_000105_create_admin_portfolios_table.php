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
        Schema::create('admin_portfolios', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->unique();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete("cascade")->onUpdate('cascade');
            foreach (socialMedia() as $val) {
                $table->string($val['name_en'])->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_portfolios');
    }
};
