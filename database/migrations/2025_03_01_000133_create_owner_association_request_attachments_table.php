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

        Schema::create('owner_association_request_attachments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('owner_association_request_id');
            $table->foreign('owner_association_request_id', 'oa_req_att_req_fk')
                ->references('id')
                ->on('owner_association_requests')
                ->cascadeOnDelete();

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable(); // image, document, pdf
                                                     // $table->integer('file_size')->nullable(); // بالـ KB
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_association_request_attachments');
    }
};
