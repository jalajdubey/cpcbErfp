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
       Schema::create('chemical_stored_lists', function (Blueprint $table) {
            $table->id();
            $table->string('part', 5);                // Roman numerals like I, II, III
            $table->integer('sr_no');
            $table->string('chemical_name', 255);     // Chemical names can be long but usually under 150 chars
            $table->decimal('threshold_qty', 10, 2);  // Precision + scale for more accurate quantities
            $table->string('cas_number', 20);         // CAS numbers like "50-00-0" are short
            $table->string('group', 150);              // Group name — up to you
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chemical_stored_list');
    }
};
