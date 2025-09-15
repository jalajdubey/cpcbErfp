<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            // Add new column
            $table->string('name_of_insurance_company')->nullable()->after('user_id');

            // Modify existing columns to nullable and decimal(15,2)
            $table->decimal('indemnity_limit_rs', 15, 2)->nullable()->change();
            $table->decimal('any_one_year_limit_rs', 15, 2)->nullable()->change();
            $table->decimal('any_one_accident_limit_rs', 15, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table(' industry_master_data_backups', function (Blueprint $table) {
            // Remove added column
            $table->dropColumn('name_of_insurance_company');

            // Revert to original types – adjust as per your original definition
            $table->integer('indemnity_limit_rs')->nullable(false)->change();
            $table->integer('any_one_year_limit_rs')->nullable(false)->change();
            $table->integer('any_one_accident_limit_rs')->nullable(false)->change();
        });
    }
};
