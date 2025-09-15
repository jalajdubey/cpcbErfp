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
            $table->string('insured_company_id', 255)->nullable()->change();
        });

        Schema::table('backup_uploaded_documents', function (Blueprint $table) {
            $table->string('insured_company_id', 255)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('uploaded_documents', function (Blueprint $table) {
            $table->string('insured_company_id', 255)->nullable(false)->change();
        });

        Schema::table('backup_uploaded_documents', function (Blueprint $table) {
            $table->string('insured_company_id', 255)->nullable(false)->change();
        });
    }
};
