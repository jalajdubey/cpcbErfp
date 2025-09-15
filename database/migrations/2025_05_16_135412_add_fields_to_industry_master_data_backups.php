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
              $table->date('date_of_erf_payment')->nullable()->after('date_of_proposal');
            $table->integer('any_one_year_limit_rs')->nullable()->after('date_of_erf_payment');
            $table->integer('any_one_accident_limit_rs')->nullable()->after('any_one_year_limit_rs');
            $table->string('policy_duration_year')->nullable()->after('paid_up_capital_cr');
            $table->integer('policy_period')->nullable()->after('policy_duration_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            //
            $table->dropColumn(['date_of_erf_payment', 'any_one_year_limit_rs', 'any_one_accident_limit_rs','policy_duration_year','policy_period']);
        });
    }
};
