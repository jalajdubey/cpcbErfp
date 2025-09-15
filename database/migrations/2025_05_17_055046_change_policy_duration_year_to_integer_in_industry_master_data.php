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
            $table->integer('policy_duration_year')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            $table->string('policy_duration_year', 255)->nullable()->change();
        });
    }
};
