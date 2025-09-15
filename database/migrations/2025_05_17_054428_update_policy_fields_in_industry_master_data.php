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
        Schema::table('industry_master_data', function (Blueprint $table) {
            // Rename column first
            $table->renameColumn('policy_period', 'policy_valid_upto');
        });

        Schema::table('industry_master_data', function (Blueprint $table) {
            // Change column types
            $table->integer('policy_duration_year')->nullable()->change();
            $table->date('policy_valid_upto')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            // Revert types
            $table->string('policy_duration_year')->nullable()->change();
            $table->string('policy_valid_upto')->nullable()->change(); // fallback if original type was varchar
        });

        Schema::table('industry_master_data', function (Blueprint $table) {
            // Revert rename
            $table->renameColumn('policy_valid_upto', 'policy_period');
        });
    }
};
