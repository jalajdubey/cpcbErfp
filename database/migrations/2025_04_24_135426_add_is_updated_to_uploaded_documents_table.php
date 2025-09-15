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
        Schema::table('uploaded_documents', function (Blueprint $table) {
            $table->boolean('is_updated')
                ->default(0)
                ->comment('0 = No update, 1 = Updated');
        });
    }

    public function down()
    {
        Schema::table('uploaded_documents', function (Blueprint $table) {
            $table->dropColumn('is_updated');
        });
    }
};
