<?php

namespace App\Http\Controllers;
use App\Models\User; // Assuming you're using the User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\IndustryMasterData;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Exports\InsuranceCompanyExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Services\UserRole;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IndustryPolicyExport;
use App\Models\UploadedDocument;
use Yajra\DataTables\Facades\DataTables;
class AdminInsurance extends Controller
{
    //
    protected $UserRole;
    // Adding middleware to ensure only admins can access methods in this controller
    public function __construct(UserRole $UserRole)
    {
        $this->UserRole = $UserRole;
    }

    public function AdminInsurance(Request $request)
    {
        $userId = Auth::id(); 
        $user = Auth::user();
    
        $companyName = $user->industry?->name_of_general_insurance_company ?? 'N/A';
        $totalAmount = IndustryMasterData::where('user_id', $userId)->sum('contribution_to_erf_rs');
        // Start query builder (do NOT call get() yet)
        $query = IndustryMasterData::where('user_id', $userId)
            ->with('uploadedDocuments');
        
    
        // Now run the query
        $industryPolicies = $query->orderBy('created_at', 'desc')->paginate(10);
    
        // If you want total count (not just paginated), clone the query before paginate
        $totalPolicies = (clone $query)->count();
    
        return view('insurance.dashboard', [
            'companyName' => $companyName,
            'totalPolicies' => $totalPolicies,
            'industryPolicies' => $industryPolicies,
            'totalAmount' => $totalAmount 
           
        ]);
    }

    public function showPolicies($company, Request $request)
{
    $userId = Auth::id();
  

    $query = IndustryMasterData::with('uploadedDocuments')
        ->where('user_id', $userId);

   

     
    $industryPolicies = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

    return view('insurance.company-policies', compact('company', 'industryPolicies'));
}



public function ajaxPolicies(Request $request)
{
    $userId = Auth::id();
   
    $query = IndustryMasterData::with('uploadedDocuments')
        ->where('user_id', $userId);
        
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }


        return DataTables::eloquent($query)
        ->filter(function ($query) use ($request) {
            if ($request->search['value']) {
                $search = $request->search['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('insured_company_id', 'like', "%$search%")
                      ->orWhere('policy_number', 'like', "%$search%")
                      ->orWhere('name_of_insured_owner', 'like', "%$search%");
                });
            }
        })
        ->addIndexColumn()
        ->editColumn('created_at', fn($row) => \Carbon\Carbon::parse($row->created_at)->format('d-m-Y'))
        ->addColumn('documents', function ($policy) {
            return $policy->uploadedDocuments->map(function ($doc) {
                return '<a href="' . asset('storage/app/public/' . $doc->file_path) . '" target="_blank">' . basename($doc->file_path) . '</a>';
            })->implode('<br>') ?: 'No documents';
        })
        ->addColumn('action', function ($policy) {
            return '<button class="btn btn-sm btn-info view-policy-btn" data-policy="' . $policy->policy_number . '">View</button>';
        })
        ->rawColumns(['documents', 'action'])
        ->make(true);
}






     public function export(Request $request)
     {
         $userId = Auth::id(); // Or from token
         $search = $request->input('search');
     
         return Excel::download(new IndustryPolicyExport($userId, $search), 'industry_policies.xlsx');
     }

     
     public function getPolicyDetails($policy_number)
     {
         $policy = IndustryMasterData::where('policy_number', $policy_number)->firstOrFail();
         return view('admin.partials.policy-modal-content', compact('policy'))->render();
     }

     public function exportPDF($policy_number)
{
    $insurance = IndustryMasterData::where('policy_number', $policy_number)->first();

    if (!$insurance) {
        abort(404, 'Policy not found');
    }

    $pdf = Pdf::loadView('pdf.insurance-details', compact('insurance'))
              ->setPaper('a4', 'portrait');

    return $pdf->download("Policy_{$policy_number}.pdf");
}


}
