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
        Schema::create('industry_chemical_backups', function (Blueprint $table) {
             $table->id(); // Auto-increment primary key (id)
            $table->unsignedBigInteger('industry_chemicals_id'); // Reference to original table
            $table->unsignedBigInteger('industry_master_data_id');
            $table->unsignedBigInteger('chemical_stored_lists_id');
            $table->decimal('quantity', 10, 2)->nullable();
            $table->string('unit', 50);
            $table->tinyInteger('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Optionally, add foreign keys:
            // $table->foreign('industry_chemicals_id')->references('id')->on('industry_chemicals');
            // $table->foreign('industry_master_data_id')->references('id')->on('industry_master_data');
            // $table->foreign('chemical_stored_lists_id')->references('id')->on('chemical_stored_lists');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industry_chemicals_backups');
    }
};
