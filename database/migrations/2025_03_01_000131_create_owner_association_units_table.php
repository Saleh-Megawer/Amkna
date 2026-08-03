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
        Schema::create('owner_association_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_association_id')->constrained('owner_associations')->cascadeOnDelete();
            $table->foreignId('client_id')
                ->nullable()
                ->constrained('clients')
                ->nullOnDelete()
                ->comment('مالك الوحدة الحالي');

            $table->foreignId('property_type_id')->constrained('property_types')->restrictOnDelete();
            $table->string('unit_number');
            $table->unique(['owner_association_id', 'property_type_id', 'unit_number'], 'oa_units_unique');
            $table->string('floor')->nullable();
            // Admin
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_association_units');
    }
};
