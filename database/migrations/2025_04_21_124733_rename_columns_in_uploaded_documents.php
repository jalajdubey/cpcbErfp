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
        Schema::table('uploaded_documents', function (Blueprint $table) {
            $table->renameColumn('upload_batch_reference', 'batch_reference');
            $table->renameColumn('upload_insured_company_id', 'insured_company_id'); // fixed extra space
            $table->renameColumn('upload_policy_number', 'policy_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uploaded_documents', function (Blueprint $table) {
            $table->renameColumn('batch_reference', 'upload_batch_reference');
            $table->renameColumn('insured_company_id', 'upload_insured_company_id');
            $table->renameColumn('policy_number', 'upload_policy_number');
        });
    }
};
