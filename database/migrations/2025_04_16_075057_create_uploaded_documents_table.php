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
        Schema::create('uploaded_documents', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('upload_batch_reference')->nullable();
            $table->string('upload_insured_company_id');
            $table->string('upload_policy_number');
            $table->timestamps();

            // Unique constraint on insured_company_id + policy_number
            $table->unique(
                ['upload_insured_company_id', 'upload_policy_number'],
                'unique_uploaded_policy_per_company'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploaded_documents');
    }
};
