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
        // Step 1: Rename the column
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            $table->renameColumn('policy_period', 'policy_valid_upto');
        });

        // Step 2: Change its type from integer to date
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            $table->date('policy_valid_upto')->nullable()->change();
        });
    }

    public function down()
    {
        // Step 1: Change back to integer
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            $table->integer('policy_valid_upto')->nullable()->change();
        });

        // Step 2: Rename the column back
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            $table->renameColumn('policy_valid_upto', 'policy_period');
        });
    }
};
