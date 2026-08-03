<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_finishing_type_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('property_finishing_type_id');

            $table->foreign('property_finishing_type_id', 'pft_trans_fk')
                ->references('id')
                ->on('property_finishing_types')
                ->onDelete('cascade');

            $table->string('locale', 10);
            $table->string('name', 150);

            $table->unique(
                ['property_finishing_type_id', 'locale'],
                'pft_locale_unique'
            );
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('property_finishing_type_translations');
    }
};
