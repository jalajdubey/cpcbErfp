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
        Schema::table('industry_master_data', function (Blueprint $table) {
            //
             $table->dropColumn(['date_of_erf_payment', 'aggregate_limit_rs', 'anyone_occurence_limit_rs']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            //
                $table->string('date_of_erf_payment')->nullable();  // Replace with actual type
            $table->string('aggregate_limit_rs')->nullable(); // Replace with actual type
            $table->string('anyone_occurence_limit_rs')->nullable();  // Replace with actual type
        });
    }
};
