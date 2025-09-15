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
        Schema::table('documents_files', function (Blueprint $table) {
            $table->string('batch_reference')->nullable();
            $table->string('insured_company_id');
            $table->string('policy_number');
        
            // Enforce uniqueness only for the combination (not individually)
            $table->unique(['insured_company_id', 'policy_number'], 'unique_insured_policy');
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents_files', function (Blueprint $table) {
            $table->dropUnique('unique_insured_policy');
            $table->dropColumn(['batch_reference', 'insured_company_id', 'policy_number']);
    });
    }
};
