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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('industry_id')->nullable()->after('id');
            $table->string('policy_number', 50)->nullable()->after('industry_id');
            $table->string('industry_name')->nullable()->after('policy_number');
            $table->unsignedBigInteger('insured_company_id')->nullable()->after('industry_name');

            // (Optional) quick address denormalization
            $table->string('industry_address_line1')->nullable();
            $table->string('industry_address_line2')->nullable();
            $table->string('industry_city')->nullable();
            $table->string('industry_state')->nullable();
            $table->string('industry_pincode', 20)->nullable();

            $table->index('industry_id');
            $table->index('policy_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn([
                'industry_id',
                'policy_number',
                'industry_name',
                'insured_company_id',
                'industry_address_line1',
                'industry_address_line2',
                'industry_city',
                'industry_state',
                'industry_pincode'
            ]);
        });
    }
};
