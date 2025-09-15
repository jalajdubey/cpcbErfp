<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\IndustryMasterData;
class CompanyInsuranceExport implements FromView
{
    protected $request, $company;

    public function __construct(Request $request, $company)
    {
        $this->request = $request;
        $this->company = $company;
    }

    public function view(): View
    {
        $query = IndustryMasterData::join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
    ->leftJoin('uploaded_documents', 'industry_master_data.policy_number', '=', 'uploaded_documents.policy_number')
    ->where('api_keys.name_of_general_insurance_company', $this->company)
    ->select(
        'industry_master_data.*',
        'api_keys.name_of_general_insurance_company as company_name',
        'uploaded_documents.file_path'
    );

        if ($this->request->filled('year')) {
            $query->whereYear('industry_master_data.created_at', $this->request->year);
        }

        if ($this->request->filled('month')) {
            $query->whereMonth('industry_master_data.created_at', $this->request->month);
        }

        if ($this->request->filled('from_date')) {
            $query->whereDate('industry_master_data.created_at', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('industry_master_data.created_at', '<=', $this->request->to_date);
        }

        $insuranceData = $query->get();

        return view('admin.exports.company-insurance-excel', compact('insuranceData'));
    }
}
