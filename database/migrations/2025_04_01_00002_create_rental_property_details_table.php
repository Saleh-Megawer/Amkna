<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('rental_property_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rental_contract_id')
                ->constrained('rental_contracts')
                ->cascadeOnDelete();

            // Location
            $table->foreignId('city_id')
                ->nullable()
                ->constrained('cities')
                ->nullOnDelete();

            $table->foreignId('neighborhood_id')
                ->nullable()
                ->constrained('neighborhoods')
                ->nullOnDelete();

            // Property Type
            $table->foreignId('property_type_id')
                ->nullable()
                ->constrained('property_types')
                ->nullOnDelete();

            // Details
            $table->text('address')->nullable()->comment('العنوان التفصيلي');
            $table->float('area')->nullable()->comment('المساحة');
            $table->unsignedTinyInteger('bedrooms')->nullable()->comment('عدد الغرف');
            $table->unsignedTinyInteger('bathrooms')->nullable()->comment('عدد الحمامات');
            $table->string('floor', 50)->nullable()->comment('الدور');
            $table->text('description')->nullable()->comment('وصف العقار');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_property_details');

    }
};
