<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryMasterData extends Model
{
    use HasFactory;
    protected $table = 'industry_master_data'; // Specify the table name

    protected $fillable = [
        'batch_reference',
        'insured_company_id',
        'name_of_insured_owner',
        'name_of_insurance_company',
        'business_type',
        'address',
        'territorial_limits_district',
        'territorial_limits_state',
        'annual_turnover_cr',
        'policy_duration_year',
        'policy_valid_upto',
        'any_one_year_limit_rs',
        'paid_up_capital_cr',
        'any_one_accident_limit_rs',
        'policy_period_month',
        'indemnity_limit_rs',
        'premium_without_tax_rs',
        'contribution_to_erf_rs',
        'date_of_proposal',
        'erf_deposit_utr_no',
        'date_of_erf_payment',
        'pan_of_company',
        'gst_of_company',
        'email_of_company',
        'mobile_of_company',
        'policy_number',
        'date_of_policy',
        'user_id'
    ];
    public function uploadedDocuments()
    {
        return $this->hasMany(UploadedDocument::class, 'policy_number', 'policy_number');
    }

      public function apiKey()
{
    return $this->belongsTo(ApiKey::class, 'user_id', 'user_id');
}
}
