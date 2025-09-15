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
        //
        Schema::table('innsurance_company_name', function (Blueprint $table) {
            $table->string('insurance_company')->nullable(); // Use appropriate column type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('innsurance_company_name', function (Blueprint $table) {
            $table->dropColumn('insurance_company');
        });
    }
};
