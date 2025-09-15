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
                  $table->string('name_of_insurance_company')->nullable()->after('user_id'); // adjust position as needed
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            //
            $table->dropColumn('name_of_insurance_company');

        });
    }
};
