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
        Schema::create('districts', function (Blueprint $table) {
            $table->id('district_id'); // PRIMARY KEY
            $table->string('district_name');
            $table->unsignedBigInteger('state_id'); // FOREIGN KEY column
            $table->timestamps();
    
            // Foreign key constraint
            $table->foreign('state_id')
                  ->references('state_id')
                  ->on('states')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};
