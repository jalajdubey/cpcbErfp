<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryMasterDataBackup extends Model
{
    use HasFactory;
    protected $table = 'industry_master_data_backups';

    protected $fillable = [
        'user_id',
        'insured_company_id',
        'name_of_insurance_company',
        'name_of_insured_owner',
        'business_type',
        'address',
        'territorial_limits_district',
        'territorial_limits_state',
        'annual_turnover_cr',
        'paid_up_capital_cr',
        'policy_period_year',
        'policy_period_month',
        'policy_duration_year',
        'indemnity_limit_rs',
        'premium_without_tax_rs',
        'contribution_to_erf_rs',
        'date_of_proposal',
        'date_of_erf_payment',
        'policy_valid_upto',
        'erf_deposit_utr_no',
        'pan_of_company',
        'gst_of_company',
        'email_of_company',
        'mobile_of_company',
        'policy_number',
        'date_of_policy',
        'batch_reference',
        'original_batch_reference',
    ];
    
}
