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
            $table->string('erf_deposit_utr_no')->nullable()->after('contribution_to_erf_rs');
        });
    }

    public function down(): void
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            $table->dropColumn('erf_deposit_utr_no');
        });
    }
};
