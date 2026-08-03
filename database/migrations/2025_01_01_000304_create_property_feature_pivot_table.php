<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_feature', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->constrained('properties')
                ->onDelete('cascade');

            $table->foreignId('property_feature_id')
                ->constrained('property_features')
                ->onDelete('cascade');

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('property_feature');
    }
};
