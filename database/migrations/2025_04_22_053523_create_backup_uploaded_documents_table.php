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
        Schema::create('backup_uploaded_documents', function (Blueprint $table) {
                        $table->id();
                        $table->unsignedBigInteger('original_id');
                        $table->unsignedBigInteger('user_id');
                        $table->string('original_name');
                        $table->string('file_path');
                        $table->string('mime_type');
                        $table->integer('file_size');
                        $table->string('batch_reference');
                        $table->string('insured_company_id');
                        $table->string('policy_number');
                        $table->timestamps();
                        
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backup_uploaded_documents');
    }
};
