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
            $table->string('batch_reference')->after('id')->nullable(); // Adding column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industry_master_data', function (Blueprint $table) {
            $table->dropColumn('id'); // Remove column if rollback
        });
    }
};
