<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('unit_number')->nullable();
            $table->float('area')->nullable()->index();
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->unsignedInteger('price')->nullable()->index();
            $table->string('image', 150)->nullable();

            //  $table->unsignedInteger('sale_price')->nullable()->index();
            //  $table->unsignedInteger('rent_price_monthly')->nullable()->index();
            //   $table->string('floor', 50)->nullable();
            //   $table->enum('availability_status', ['available', 'reserved', 'rented', 'sold'])->default('available');

            //
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('property_attachments');
    }
};
