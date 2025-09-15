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
        Schema::table('backup_uploaded_documents', function (Blueprint $table) {
            //
            $table->integer('version')->default(1)->after('original_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backup_uploaded_documents', function (Blueprint $table) {
            //
            $table->integer('version')->default(1)->after('original_id');
        });
    }
};
