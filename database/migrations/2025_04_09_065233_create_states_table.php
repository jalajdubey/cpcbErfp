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
        Schema::create('states', function (Blueprint $table) {
            $table->id('state_id'); // PRIMARY KEY
            $table->string('state_name');
            $table->unsignedBigInteger('country_id'); // FOREIGN KEY column
            $table->boolean('status')->default(true); // optional
            $table->timestamps();
    
            // Foreign key constraint
            $table->foreign('country_id')
                  ->references('country_id')
                  ->on('countries')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
