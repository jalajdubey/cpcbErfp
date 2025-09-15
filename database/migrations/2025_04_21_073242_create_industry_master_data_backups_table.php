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
        Schema::create('industry_master_data_backups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('insured_company_id');
            $table->string('name_of_insured_owner');
            $table->string('business_type');
            $table->string('address');
            $table->string('territorial_limits_district');
            $table->string('territorial_limits_state');
            $table->decimal('annual_turnover_cr', 12, 2);
            $table->decimal('paid_up_capital_cr', 12, 2);
            $table->integer('policy_period_year');
            $table->integer('policy_period_month');
            $table->decimal('indemnity_limit_rs', 15, 2);
            $table->decimal('premium_without_tax_rs', 15, 2);
            $table->decimal('contribution_to_erf_rs', 15, 2);
            $table->date('date_of_proposal');
            $table->string('payment_particulars');
            $table->string('pan_of_company');
            $table->string('gst_of_company');
            $table->string('email_of_company');
            $table->string('mobile_of_company');
            $table->string('policy_number');
            $table->date('date_of_policy');
            $table->string('batch_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry_master_data_backups');
    }
};
