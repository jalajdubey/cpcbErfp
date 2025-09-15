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
            $table->integer('policy_duration_year')->nullable()->change(); // Change from varchar to integer
        });
    }

    public function down()
    {
        Schema::table('industry_master_data_backups', function (Blueprint $table) {
            $table->string('policy_duration_year', 255)->nullable()->change(); // Revert back to varchar
        });
    }
};
