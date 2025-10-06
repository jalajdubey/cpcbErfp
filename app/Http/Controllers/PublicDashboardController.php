<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\IndustryMasterData;

class PublicDashboardController extends Controller
{
    public function index()
    {
        // Industries insured per company
        $policyData = IndustryMasterData::select(
                            'name_of_insurance_company',
                            DB::raw('COUNT(DISTINCT insured_company_id) as total')
                        )
                        ->groupBy('name_of_insurance_company')
                        ->get();

        $labels = $policyData->pluck('name_of_insurance_company');
        $industryCounts = $policyData->pluck('total');

        // ERF contribution per company
        $erfData = IndustryMasterData::select(
                            'name_of_insurance_company',
                            DB::raw('SUM(contribution_to_erf_rs) as total_erf')
                        )
                        ->groupBy('name_of_insurance_company')
                        ->get();

        $erfLabels = $erfData->pluck('name_of_insurance_company');
        $erfAmounts = $erfData->pluck('total_erf');
        $erfTotal   = $erfAmounts->sum();
     
        // dd($erfTreemapData);
        // 🔹 Year-wise stats
        $yearWiseData = IndustryMasterData::selectRaw("
            YEAR(date_of_policy) as policy_year,
            COUNT(DISTINCT insured_company_id) as industries_count,
            COUNT(DISTINCT policy_number) as policies_count,
            SUM(premium_without_tax_rs) as total_premium,
            SUM(contribution_to_erf_rs) as erf_total
        ")
        ->groupBy('policy_year')
        ->orderBy('policy_year', 'asc')
        ->get();

        //on 16-09-2025
        
        $industryByCompany = IndustryMasterData::select(
        'name_of_insurance_company',
        DB::raw('COUNT(DISTINCT insured_company_id) as industries_count'),
        DB::raw('SUM(contribution_to_erf_rs) as total_erf')
    )
    ->groupBy('name_of_insurance_company')
    ->orderByDesc('industries_count')
    ->get();

    // Labels as short codes
    $companyLabels = $industryByCompany->map(function ($row) {
        return collect(explode(' ', $row->name_of_insurance_company))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->implode('');
    });

    // Values
    $companyIndustries = $industryByCompany->pluck('industries_count');
    $companyErf = $industryByCompany->pluck('total_erf');

    // Month-wise policies taken with amount
        $monthlyPolicies = IndustryMasterData::selectRaw("
        YEAR(date_of_policy) as year,
        MONTH(date_of_policy) as month,
        COUNT(DISTINCT policy_number) as total_policies,
        SUM(contribution_to_erf_rs) as total_amount
    ")
    ->groupBy('year', 'month')
    ->orderBy('year')
    ->orderBy('month')
    ->get();

$months = [];
$policyCounts = [];
$policyAmounts = [];

foreach ($monthlyPolicies as $row) {
    $monthName = date("M", mktime(0, 0, 0, $row->month, 1));
    $months[] = $monthName . " " . $row->year;
    $policyCounts[] = $row->total_policies;
    $policyAmounts[] = round($row->total_amount / 100000, 2); // convert to Lacs
}

//total erf contibution in cr
// Grand total ERF Contribution (in Crores)
$totalErfContribution = IndustryMasterData::sum('contribution_to_erf_rs');
$totalErfContributionCr = round($totalErfContribution / 10000000, 2); // in Cr

  

    return view('home.publicdashboard', compact(
       'labels',
    'industryCounts',
    'erfLabels',
    'erfAmounts',
    'erfTotal',
    'yearWiseData',
    'companyLabels',
    'companyIndustries',
    'companyErf',
    'months',
    'policyCounts',
    'policyAmounts',
    'totalErfContributionCr'
    ));
       // return view('home.publicdashboard', compact('labels', 'industryCounts', 'erfLabels', 'erfAmounts', 'erfTotal','yearWiseData'));
    }

    public function insuranceIndustryReport()
    {
        // Insurance company summary
        $insuranceCompanies = DB::table('industry_master_data')
            ->select(
                'name_of_insurance_company',
                DB::raw('COUNT(DISTINCT insured_company_id) as industries'),
                DB::raw('SUM(contribution_to_erf_rs) as total_erf')
            )
            ->groupBy('name_of_insurance_company')
            ->orderByDesc('total_erf')
            ->get();

        // Industry-wise detail
        $industries = DB::table('industry_master_data')
            ->select('name_of_insured_owner', 'name_of_insurance_company', 'contribution_to_erf_rs')
            ->orderBy('name_of_insurance_company')
            ->get();

        return view('home.insurance_industry_report', compact('insuranceCompanies', 'industries'));
    }

}
