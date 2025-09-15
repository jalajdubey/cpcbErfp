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
        Schema::table('api_keys', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['user_id']); // or $table->dropForeign('api_keys_user_id_foreign');

            // Now drop the column
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        Schema::table('api_keys', function (Blueprint $table) {
            // Add the column back
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }
};
