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
        Schema::table('api_keys', function (Blueprint $table) {
            //
            $table->string('name_of_general_insurance_company')->nullable()->after('active');
            $table->string('company_address')->nullable()->after('name_of_general_insurance_company');
            $table->string('name_of_ceo', 1000)->nullable()->after('company_address'); // Corrected
            $table->string('name_of_actuary', 1000)->nullable()->after('name_of_ceo');  // Corrected
            $table->string('contact_no', 15)->nullable()->after('name_of_actuary');
            $table->string('web_address', 1000)->nullable()->after('contact_no');     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            //
            $table->dropColumn([
                'name_of_general_insurance_company',
                'company_address',
                'name_of_ceo',
                'name_of_actuary',
                'contact_no',
                'web_address',
            ]);
        });
    }
};
