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
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            //
             $table->dropColumn(['policy_period_year', 'policy_period_month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            //
             $table->dropColumn(['policy_period_year', 'policy_period_month']);
        });
    }
};
