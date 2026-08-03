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
        Schema::create('clients', function (Blueprint $table) {

            // =========================
            // Primary Keys
            // =========================
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();

            // =========================
            // Personal Information
            // =========================
            $table->string('name', 100);
            $table->string('avatar', 100)->nullable();

            // =========================
            // Owner Information
            // =========================
            $table->string('national_id', 40)->unique()->nullable()->comment('Owner national ID');
            $table->date('birth_date')->nullable()->comment('Owner date of birth');
            $table->string('national_address', 255)->nullable()->comment('National address');

            // =========================
            // Contact Information
            // =========================
            $table->string('email', 191)->nullable()->unique();
            $table->string('password', 150)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            //
            $table->string('phone_e164', 20)->unique()->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('phone', 30)->nullable();

            // =========================
            // Relations
            // =========================
            // $table->foreignId('status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->foreignId('source_id')->nullable()->constrained('sources')->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->foreignId('neighborhood_id')->nullable()->constrained('neighborhoods')->nullOnDelete();

            // =========================
            // Account Status
            // =========================
            $table->enum('status', [1, 0])->default(1)->comment("If the account is banned, the value will be 0");
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_read')->default(false);
            $table->boolean('has_account')->default(false)->comment('Client has real login account');

            // =========================
            // Activity
            // =========================
            $table->timestamp('last_seen')->nullable();

            // =========================
            // Meta
            // =========================
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
