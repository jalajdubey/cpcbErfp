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
            //
            $table->decimal('indemnity_limit_rs', 12, 2)->nullable()->change();
            $table->decimal('any_one_year_limit_rs', 12, 2)->nullable()->change(); // ✅ Now nullable
            $table->decimal('any_one_accident_limit_rs', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            //
             $table->decimal('indemnity_limit_rs', 12, 2)->nullable(false)->change();
            $table->decimal('any_one_year_limit_rs', 12, 2)->nullable(false)->change(); // Rollback to not nullable
            $table->decimal('any_one_accident_limit_rs', 12, 2)->nullable(false)->change();
        });
    }
};
