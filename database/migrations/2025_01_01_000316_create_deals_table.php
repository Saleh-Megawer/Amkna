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

        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            // The deal belongs to a specific client
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            $table->foreignId('source_id')->nullable()->constrained('sources')->nullOnDelete();

            $table->foreignId('interest_id')->nullable()->constrained('interests')->nullOnDelete();

            // The current status of the deal (negotiation, completed, lost, etc.)
            // $table->foreignId('status_id')->nullable()->constrained('statuses')->nullOnDelete();

            // The admin assigned to this deal
            $table->foreignId('assigned_to')->nullable()->constrained('admins')->nullOnDelete();

            //
            $table->foreignId('property_type_id')->nullable()->constrained('property_types')->nullOnDelete();

            // Deal details
            $table->decimal('amount', 15, 2)->nullable()->comment('Deal value (price)');
            $table->decimal('commission', 15, 2)->comment('Company Commission Amount')->nullable();
            $table->decimal('marketer_commission', 15, 2)->comment('Marketer Commission Amount')->nullable();

            // Deal Propirtes
            $table->unsignedBigInteger('budget_min')->nullable();
            $table->unsignedBigInteger('budget_max')->nullable();

            $table->tinyInteger('rating')->nullable(); // Rating for the deal
            $table->boolean('is_won')->default(false); // Indicates if the deal was successfully closed
            $table->boolean('is_lost')->default(false);

            $table->foreignId('facade_id')->nullable()->constrained('property_facades')->nullOnDelete();
            $table->integer('area_min')->nullable();
            $table->integer('area_max')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();

            $table->enum('purpose', ['rent', 'buy']);

            //
            // Relation
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();

            $table->text('notes')->nullable();

            // The admin who created the deal
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for better query performance
            $table->index(['assigned_to', 'is_won', 'purpose']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
