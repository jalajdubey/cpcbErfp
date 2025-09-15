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
            $table->decimal('paid_up_capital_cr', 10, 2)->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            $table->decimal('paid_up_capital_cr', 10, 2)->default(0.00)->nullable(false)->change(); // rollback
        });
    }
};
