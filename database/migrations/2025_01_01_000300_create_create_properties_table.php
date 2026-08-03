<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Basic data
            $table->uuid('uuid')->unique()->index();
            $table->string('main_image', 100)->nullable();

            // Price & area
            $table->float('area')->nullable()->index();
            $table->string('purpose', 50)->nullable();

            // Rent prices (new)
            $table->unsignedInteger('sale_price')->nullable()->index();
            $table->unsignedInteger('rent_price_monthly')->nullable()->index();
            $table->unsignedInteger('rent_price_quarterly')->nullable()->index();
            $table->unsignedInteger('rent_price_semi_annually')->nullable()->index();
            $table->unsignedInteger('rent_price_annually')->nullable()->index();

            //
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->string('floor', 50)->nullable();
            $table->unsignedTinyInteger('number_of_floors')->nullable();
            $table->string('plan_number', 100)->nullable();
            $table->string('plot_number', 100)->nullable();
            $table->string('license_number', 100)->nullable();
            $table->string('youtube_video_url', 255)->nullable();

            $table->foreignId('facade_id')->nullable()->constrained('property_facades')->nullOnDelete();

            // Admin
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();

            // Location
            $table->text('google_map_iframe')->nullable();
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->constrained()->nullOnDelete();

            // References
            $table->foreignId('property_type_id')->nullable()->constrained('property_types')->nullOnDelete();
            $table->foreignId('property_status_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('property_finishing_type_id')->nullable()->constrained()->nullOnDelete();

            ////////////////////////////
            $table->boolean('is_archived')->default(true);

            // $table->timestamp('archived_at')->nullable();
            // $table->foreignId('archived_by')->nullable()->constrained('admins')->nullOnDelete();
            // $table->string('archive_reason', 255)->nullable();

            // Client who owns / submitted the property (if added from client account)
            $table->unsignedBigInteger('client_id')->nullable()->comment('Client who submitted the property for sale or rent')->index();

            // Property approval workflow status
            $table->enum('approval_status', [
                'pending',  // Waiting for admin review
                'approved', // Approved and visible on website
                'rejected', // Rejected by admin
            ])->default('pending')->comment('Approval status of the property (admin review)')->index();
            // Reason for rejection (filled only if rejected)
            $table->string('rejection_reason', 255)->nullable()->comment('Reason for rejecting the property by admin');

            // Fulltext fields (Arabic)
            $table->string('title_normalized_ar', 191);
            $table->text('description_normalized_ar')->nullable();

            // Fulltext fields (English)
            $table->string('title_normalized_en', 191);
            $table->text('description_normalized_en')->nullable();

            //  $table->text('notes')->nullable();

            $table->string('availability_status')->default('available')->comment('available, reserved, rented, sold');

            // Stats
            $table->unsignedBigInteger('views_count')->default(0)->index();

            $table->timestamps();

        });

        DB::statement('ALTER TABLE properties ADD FULLTEXT ft_ar (title_normalized_ar, description_normalized_ar)');
        DB::statement('ALTER TABLE properties ADD FULLTEXT ft_en (title_normalized_en, description_normalized_en)');

    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
