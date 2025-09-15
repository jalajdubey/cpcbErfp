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
        Schema::table('industry_master_data', function (Blueprint $table) {
            $table->dropUnique('industry_master_data_batch_reference_unique'); // Remove unique constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            $table->unique('batch_reference'); // Re-add unique constraint if rolled back
        });
    }
};
