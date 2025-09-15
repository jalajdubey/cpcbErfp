<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you're using the User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\LoginAttempt;
use App\Services\UserRole;
use App\Models\ApiKey;
use App\Rules\RestrictPatternPassword;
use Illuminate\Validation\Rules\Password;
use App\Models\IndustryMasterData;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Exports\InsuranceCompanyExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\CompanyInsuranceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Exports\ErfExport;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    protected $UserRole;
    // Adding middleware to ensure only admins can access methods in this controller
    public function __construct(UserRole $UserRole)
    {
        $this->UserRole = $UserRole;
    }


    public function navdetails()
    {
        
        // Fetch some data you want to show on dashboard, for example, the number of users
        $user = Auth::user(); // Fetch all users
      
         // Ensure users are passed to the dashboard view
         return view('layouts.top-navbar.blade', ['user' => $user]);
       
    }

    public function adminindex($company)
    {
      
         $company = Crypt::decryptString(base64_decode(urldecode($company)));
        $years = range(now()->year, 2025);
         
        return view('admin.insurance-by-company', compact('company', 'years'));
    }
   // this code comment due to duplicay of insurance company and user id in api key table need to deploye once testing done 
    // public function getData(Request $request, $company)
    // {
    //     $query = DB::table('industry_master_data')
    //         ->join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
    //         ->leftJoin('uploaded_documents', 'industry_master_data.policy_number', '=', 'uploaded_documents.policy_number')
    //         ->select(
    //             'industry_master_data.*',
    //             'api_keys.name_of_general_insurance_company as company_name',
    //             'uploaded_documents.file_path'
    //         )
    //         ->where('api_keys.name_of_general_insurance_company', $company);
    
    //     if ($request->filled('year')) {
    //         $query->whereYear('industry_master_data.created_at', $request->year);
    //     }
    
    //     if ($request->filled('month')) {
    //         $query->whereMonth('industry_master_data.created_at', $request->month);
    //     }
    
    //     if ($request->filled('from_date')) {
    //         $query->whereDate('industry_master_data.created_at', '>=', $request->from_date);
    //     }
    
    //     if ($request->filled('to_date')) {
    //         $query->whereDate('industry_master_data.created_at', '<=', $request->to_date);
    //     }
    
    //     return DataTables::of($query)
    //         ->addIndexColumn()
    //         ->editColumn('created_at', fn($row) => \Carbon\Carbon::parse($row->created_at)->format('d-m-Y'))
    //         ->addColumn('documents', function ($row) {
    //             return $row->file_path
    //                 ? '<a href="' . asset('storage/app/public/' . $row->file_path) . '" target="_blank">' . basename($row->file_path) . '</a>'
    //                 : 'No document';
    //         })
    //         ->addColumn('action', function ($row) {
    //            // $encodedPolicy = urlencode($row->policy_number);
    //                return '<button class="btn btn-sm btn-info view-policy-btn" data-policy="' . $row->policy_number . '">
    //           <i class="bi bi-eye"></i> View
    //         </button>';
    //         })
    //         ->rawColumns(['documents', 'action'])
    //         ->make(true);
    // }

// added at 29-05-2025 this code for testing due to duplicate insurenace company name in api key table once done need to remove or verify

public function getData(Request $request, $company)
{
    // $company = Crypt::decryptString(base64_decode(urldecode($company)));

    $query = DB::table('industry_master_data')
        ->join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
        ->leftJoin('uploaded_documents', 'industry_master_data.policy_number', '=', 'uploaded_documents.policy_number')
        ->select(
            'industry_master_data.user_id',
            'industry_master_data.policy_number',
            'industry_master_data.created_at', // Important for filtering and formatting
            'industry_master_data.name_of_insured_owner',
            'api_keys.name_of_general_insurance_company as company_name',
            'uploaded_documents.file_path'
        )
        ->where('api_keys.name_of_general_insurance_company', $company)
        ->groupBy(
            'industry_master_data.user_id',
            'industry_master_data.policy_number',
            'industry_master_data.name_of_insured_owner',
            'industry_master_data.created_at',
            'api_keys.name_of_general_insurance_company',
            'uploaded_documents.file_path'
        )
        ->distinct();
       

    // Optional filters
    if ($request->filled('year')) {
        $query->whereYear('industry_master_data.created_at', $request->year);
    }

    if ($request->filled('month')) {
        $query->whereMonth('industry_master_data.created_at', $request->month);
    }

    if ($request->filled('from_date')) {
        $query->whereDate('industry_master_data.created_at', '>=', $request->from_date);
    }

    if ($request->filled('to_date')) {
        $query->whereDate('industry_master_data.created_at', '<=', $request->to_date);
    }

    return DataTables::of($query)
        ->addIndexColumn()
        ->editColumn('created_at', function ($row) {
            return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y');
        })
     ->addColumn('action', function ($row) {
  $viewBtn = '<button type="button"
                    class="btn btn-sm btn-primary rounded-circle view-policy-btn"
                    data-policy="' . $row->policy_number . '"
                    title="View Policy" style="border-radius: 10% !important;background: #3f15e8 !important;border-color: #3f15e8 !important">
                    View
                </button>';

    // $docBtn = $row->file_path
    //     ? '<a href="' . asset('storage/app/public/' . $row->file_path) . '"
    //              target="_blank"
    //              class="btn btn-sm btn-warning rounded-circle"
    //              title="Open Document" style="border-radius: 10% !important">
    //             <i class="fa fa-download" style="padding-top: 4px;"></i>
    //        </a>'
    //     : '<button type="button"
    //                class="btn btn-sm btn-light rounded-circle"
    //                title="No Document"
    //                disabled style="border-radius: 10% !important">
    //             <i class="fa fa-download text-muted"></i>
    //        </button>';

           $docBtn = '';

            if (!empty($row->file_path) && Storage::exists('public/' . $row->file_path)) {
                //$url = URL::signedRoute('secure.file.download', ['path' => $row->file_path]);
                $url = URL::signedRoute('secure.file.download', ['path' => $row->file_path]);
                $docBtn = '<a href="' . $url . '" target="_blank" class="btn btn-sm btn-warning rounded-circle" title="View Document" style="border-radius: 10% !important;">
                    <i class="fa fa-download" style="padding-top: 4px;"></i>
                </a>';
            } else {
                $docBtn = '<button type="button" class="btn btn-sm btn-light rounded-circle" title="No Document" disabled style="border-radius: 10% !important;">
                    <i class="fa fa-download text-muted"></i>
                </button>';
            }


    return '<div class="d-flex gap-2 justify-content-start">' . $viewBtn . $docBtn . '</div>';
})
->rawColumns(['action'])
->make(true);
}

//end at get data at 29-5-2025






    public function exportExcel(Request $request, $company)
{
    return Excel::download(new CompanyInsuranceExport($request, $company), 'insurance-company-' . now()->format('YmdHis') . '.xlsx');
}
public function downloadPdf($policyNumber)
{
    $policy = IndustryMasterData::with('uploadedDocuments')
        ->where('policy_number', $policyNumber)
        ->firstOrFail();

    $pdf = Pdf::loadView('admin.exports.policy-pdf', compact('policy'));
    return $pdf->download('policy-' . $policyNumber . '.pdf');
}
public function showPolicy($policyNumber)
{
    $decodedPolicyNumber = urldecode($policyNumber);
    $policy = IndustryMasterData::with('uploadedDocuments')
        ->where('policy_number',  $decodedPolicyNumber)
        ->firstOrFail();

    return view('admin.partials.policy-modal-body', compact('policy'));
}


    // Method to show the admin dashboard
  public function index()
    {
        
        // Fetch some data you want to show on dashboard, for example, the number of users
        $users = User::all(); // Fetch all users IndustryMasterData
        $userRoles = $this->UserRole->getAllUserRoles();
        $usersIns = User::where('role_type', 4)->count();
        $uniqueUserCount = DB::table('api_keys')->distinct('user_id')  ->count('user_id');
       
  
        $totalPolicylist = IndustryMasterData::distinct('policy_number')->count('policy_number');
       // dd($totalPolicylist);
        $totalContribution = IndustryMasterData::sum('contribution_to_erf_rs');
         $totalFormatted = format_inr($totalContribution);
        // dd(  $totalContribution);
        // Ensure users are passed to the dashboard view
         return view('admin.dashboard',compact('users','userRoles','usersIns','totalPolicylist','totalContribution','uniqueUserCount'));
       
    }

    //add at 09-05-2025
     //add at 09-05-2024

   public function listofInsCompany(){

    $getDetails = ApiKey::whereIn('id', function ($query) {
        $query->selectRaw('MAX(id)')
              ->from('api_keys')
              ->groupBy('user_id');
    })->get();
    return view('admin.listofInsuranceCompanies',compact('getDetails'));
   }
    
    

//add at 30-4-2025


public function adduser(Request $request)
{
    $validator = Validator::make($request->all(), [
        'firstname'  => 'required|string|max:255',
        'lastname'   => 'required|string|max:255',
        'mobile_no'  => 'required|string|regex:/^[0-9]{10,15}$/',
        'role_type'  => 'required|string',
        'email'      => 'required|email|unique:users,email',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->with('showRegisterModal', true);
    }

    DB::beginTransaction();

    try {
        $password = Str::random(10); // generate random password
        $activationToken = Str::uuid(); // unique activation token

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobile_no = $request->mobile_no;
        $user->role_type = $request->role_type;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->activation_token = $activationToken;
        $user->is_active = false;
        $user->save();

        DB::commit();

        // Send activation mail
        Mail::to($user->email)->send(new \App\Mail\UserActivationMail($user, $password));

        return redirect()->route('dashboard')->with('success', 'User added successfully and activation email sent.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error adding new user: ' . $e->getMessage());
        return back()->withErrors(['error' => 'An error occurred while adding the user.'])->withInput();
    }
}

public function activateUser($token)
{
    $user = User::where('activation_token', $token)->first();

    if (!$user) {
        return redirect()->route('login')->withErrors(['Invalid activation link.']);
    }

    $user->is_active = true;
    $user->activation_token = null;
    $user->save();

    return redirect()->route('login')->with('success', 'Account activated successfully. You can now login.');
}






   

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');
}
public function editUser($id)
{
    $user = User::findOrFail($id);
    return view('admin.edit-user', compact('user'));
}

public function updateUser(Request $request, $id)
{
    $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname'  => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email,'.$id,
        'mobile_no' => 'required|string|max:15',
        'role_type' => 'required|string'
    ]);

    $user = User::findOrFail($id);
    $user->update([
        'firstname' => $request->firstname,
        'lastname'  => $request->lastname,
        'email'     => $request->email,
        'mobile_no' => $request->mobile_no,
        'role_type' => $request->role_type,
    ]);

    return redirect()->back()->with('success', 'User updated successfully.');
}
public function loginAttempts()
{
    $logs = LoginAttempt::latest()->paginate(50);
    return view('admin.login-attempts', compact('logs'));
}
public function getInsuranceDetails()
{
     $companies = IndustryMasterData::join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
    ->select(
        'industry_master_data.user_id',
        'api_keys.name_of_general_insurance_company as company_name',
        DB::raw('COUNT(DISTINCT industry_master_data.policy_number) as total_policies')
    )
    ->groupBy('industry_master_data.user_id', 'api_keys.name_of_general_insurance_company')
    ->orderBy('company_name')
    ->get();

    return view('admin.insurance-summary', compact('companies'));
}

public function listoferfContribution(){

    $data = IndustryMasterData::with('apiKey')
    ->selectRaw('user_id, SUM(contribution_to_erf_rs) as total_contribution, COUNT(*) as total_policies')
    ->groupBy('user_id')
    ->orderByDesc('total_contribution')
    ->get();
  $globalTotals = IndustryMasterData::selectRaw('SUM(contribution_to_erf_rs) as overall_contribution, COUNT(*) as overall_policies')->first();
        // dd( $data );
        return view('admin.erfcontributionfund', compact('data','globalTotals'));
    }


 //added at 04 /06/2025
    public function fundcontributiondetails($encrypted)
    {
        try {
            $user_id = Crypt::decryptString($encrypted);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return abort(403, 'Invalid or tampered request');
        }

        // Fetch user data from model
        $user = IndustryMasterData::where('user_id', $user_id)->firstOrFail();

        //dd( $user);

        // $contributions = DB::table('industry_master_data')
        //     ->where('user_id', $user_id)
        //     ->get();



        return view('admin.erfcontributiondetails', [
            'user' => $user,
            'encryptedUserId' => $encrypted, // Pass encrypted ID to view
        ]);
    }

// code cooment for dupicate data in erf contribution at 17/06/2025 
    // public function getErfData(Request $request)
    // {

    //     $query = DB::table('industry_master_data')
    //         ->join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
    //         ->select(
    //             'industry_master_data.policy_number',
    //             'industry_master_data.name_of_insured_owner',
    //             'industry_master_data.erf_deposit_utr_no',
    //             'industry_master_data.contribution_to_erf_rs',
    //             'industry_master_data.date_of_erf_payment',
    //             'api_keys.name_of_general_insurance_company as insurance_company'
    //         );

    //     // Decrypt and filter by user_id
    //     if ($request->filled('encrypted_user_id')) {
    //         $user_id = Crypt::decryptString($request->encrypted_user_id);
    //         $query->where('industry_master_data.user_id', $user_id);
    //     }

    //     // 🔍 Optional filters
    //     if ($request->filled('year')) {
    //         $query->whereYear('industry_master_data.date_of_erf_payment', $request->year);
    //     }

    //     if ($request->filled('start_date') && $request->filled('end_date')) {
    //         $query->whereBetween('industry_master_data.date_of_erf_payment', [
    //             $request->start_date,
    //             $request->end_date
    //         ]);
    //     }

    //     if ($request->filled('erf_deposit_utr_no')) {
    //         $query->where('industry_master_data.erf_deposit_utr_no', 'like', '%' . $request->erf_deposit_utr_no . '%');
    //     }

    //     // Return DataTable JSON
    //     if ($request->ajax()) {
    //         return DataTables::of($query)
    //             ->addIndexColumn() // Optional: adds DT_RowIndex for serial number
    //             ->make(true);
    //     }

    //     return view('admin.erfcontributiondetails');
    // }
// end coment------>


public function getErfData(Request $request)
{
    $query = DB::table('industry_master_data')
        ->join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
        ->select(
            'industry_master_data.policy_number',
            'industry_master_data.name_of_insured_owner',
            'industry_master_data.erf_deposit_utr_no',
            'industry_master_data.contribution_to_erf_rs',
            'industry_master_data.date_of_erf_payment',
            'api_keys.name_of_general_insurance_company as insurance_company'
        )
        ->distinct(); // ✅ Ensures distinct records only

    // 🔒 Decrypt and filter by user_id
    if ($request->filled('encrypted_user_id')) {
        $user_id = Crypt::decryptString($request->encrypted_user_id);
        $query->where('industry_master_data.user_id', $user_id);
    }

    // 🔍 Optional filters
    if ($request->filled('year')) {
        $query->whereYear('industry_master_data.date_of_erf_payment', $request->year);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('industry_master_data.date_of_erf_payment', [
            $request->start_date,
            $request->end_date
        ]);
    }

    if ($request->filled('erf_deposit_utr_no')) {
        $query->where('industry_master_data.erf_deposit_utr_no', 'like', '%' . $request->erf_deposit_utr_no . '%');
    }

    // Return DataTable JSON
    if ($request->ajax()) {
        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    return view('admin.erfcontributiondetails');
}



    
public function export(Request $request, $type)
{
    try {
        $user_id = Crypt::decryptString($request->encrypted_user_id);

        $filters = [
            'user_id' => $user_id,
            'year' => $request->year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'erf_deposit_utr_no' => $request->erf_deposit_utr_no,
        ];

        $filename = 'ERF_Report_' . now()->format('Ymd_His');

        if ($type === 'excel') {
            return Excel::download(new ErfExport($filters), "$filename.xlsx");
        }

        if ($type === 'pdf') {
            return Excel::download(new ErfExport($filters), "$filename.pdf", \Maatwebsite\Excel\Excel::DOMPDF);
        }

        return abort(404);

    } catch (\Throwable $e) {
        return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
    }
}


public function exportCustomPdf(Request $request)
{
    try {
        $user_id = Crypt::decryptString($request->encrypted_user_id);

        $query = DB::table('industry_master_data')
            ->join('api_keys', 'industry_master_data.user_id', '=', 'api_keys.user_id')
            ->select(
                'industry_master_data.policy_number',
                'industry_master_data.name_of_insured_owner',
                'industry_master_data.erf_deposit_utr_no',
                'industry_master_data.contribution_to_erf_rs',
                'industry_master_data.date_of_erf_payment',
                'api_keys.name_of_general_insurance_company as insurance_company'
            )
            ->where('industry_master_data.user_id', $user_id)->distinct();

        if ($request->filled('year')) {
            $query->whereYear('industry_master_data.date_of_erf_payment', $request->year);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('industry_master_data.date_of_erf_payment', [
                $request->start_date,
                $request->end_date
            ]);
        }

        if ($request->filled('erf_deposit_utr_no')) {
            $query->where('industry_master_data.erf_deposit_utr_no', $request->erf_deposit_utr_no);
        }

        $data = $query->orderBy('industry_master_data.date_of_erf_payment')->get();

        $pdf = Pdf::loadView('pdf.erf_report', ['data' => $data])
            ->setPaper('a4', 'landscape');

        return $pdf->download('ERF_Report_' . now()->format('Ymd_His') . '.pdf');

    } catch (\Exception $e) {
        return response()->json(['error' => 'PDF export failed: ' . $e->getMessage()], 500);
    }
}



    public function getUtrNumbers(Request $request)
    {
        if (!$request->filled('encrypted_user_id')) {
            return response()->json(['error' => 'Missing user id'], 400);
        }

        try {
            $user_id = Crypt::decryptString($request->encrypted_user_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Invalid user id'], 403);
        }

        $utrs = DB::table('industry_master_data')
            ->where('user_id', $user_id)
            ->whereNotNull('erf_deposit_utr_no')
            ->pluck('erf_deposit_utr_no')
            ->unique()
            ->values();

        return response()->json($utrs);
    }




}

