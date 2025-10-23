<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeUserMail;
use App\Models\ChemicalStoredList;
use Cache;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\IndustryMasterData;
use App\Models\IndustryUser;
use App\Models\LgdStateDistricts;
use App\Models\State;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Session;

class RegisterController extends Controller
{
    //
    // public function showRegistrationForm()
    // {
    //     return view('auth.register');
    // }

    // public function register(Request $request)
    // {
    //     $this->validator($request->all())->validate();

    //     $user = $this->create($request->all());

    //     auth()->login($user);

    //     return redirect()->route('home');
    // }

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }


    //new registration start at 26/7/2025
    public function showPolicyForm()
    {
        $states = LgdStateDistricts::select('state_code', 'state_name')
            ->groupBy('state_code', 'state_name')
            ->orderBy('state_name')
            ->get();
        $chemicals = ChemicalStoredList::all();
        // return view('auth.policy-check');
        return view('auth.register', compact('states', 'chemicals'));
    }

    // Non-AJAX fallback (optional)
    public function verifyPolicy(Request $request)
    {
        $request->validate(['policy_number' => 'required|string|max:150']);

        $policy = IndustryMasterData::where('pan_of_company',Auth::user()->pan_no)->where('policy_number', $request->policy_number)->first();
        // return $request->policy_number;

        if (!$policy) {
            return back()->withErrors(['policy_number' => 'Invalid policy number, please try again.']);
        }

        // Redirect using query string so slashes are safe
        return redirect()->to(route('register.form') . '?policy=' . urlencode($policy->policy_number));
    }
    // AJAX policy lookup
    public function ajaxPolicyLookup(Request $request)
    {
        $request->validate([
            'policy_number' => 'required|string|max:150'
        ]);

        $input = trim($request->input('policy_number'));
        // echo $input;

        // Exact match first
        $policy = IndustryMasterData::where('policy_number', $input)->first();

        $userAcc = User::where('policy_number', $policy->policy_number)->first();

        if ($userAcc) {
            return response()->json(['ok' => false, 'data' => ['message' => 'Policy already have account created.']], 409);
        }

        // Fallback: normalized match (remove / - _ . spaces, uppercase)
        if (!$policy) {
            $sql = "UPPER(
                  REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(policy_number,'/',''),'-',''),' ',''),'_',''),'.','')
               ) = ?";
            $normalized = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $input));
            $policy = IndustryMasterData::whereRaw($sql, [$normalized])->first();
        }

        if (!$policy) {
            return response()->json(['ok' => false, 'message' => 'Policy not found.'], 404);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'policy_number'      => $policy->policy_number,
                'insurance_company_name'      => $policy->name_of_insurance_company,
                'policy_start_date'      => date('d/m/Y', strtotime($policy->date_of_policy)),
                'policy_end_date'      => date('d/m/Y', strtotime($policy->policy_valid_upto)),
                'erfo_amount'      => $policy->contribution_to_erf_rs,
                'industry_name'      => $policy->industry_name,
                'industry_id'        => $policy->id,
                'insured_company_id' => $policy->insured_company_id,
                'address_line1'      => $policy->address_line1,
                'address_line2'      => $policy->address_line2,
                'city'               => $policy->city,
                'state'              => $policy->state,
                'pincode'            => $policy->pincode,
            ]
        ]);
    }





    // Step 3: Registration form with prefill
    public function showRegistrationForm(Request $request)
    {
        $policy = $request->query('policy');

        if (!$policy) {
            return redirect()->route('policy.check.form')
                ->with('error', 'Missing policy number. Please verify again.');
        }

        $policyData = IndustryMasterData::where('policy_number', $policy)->first();

        $userAcc = User::where('policy_number', $policyData->policy_number)->first();

        if (!$policyData) {
            return redirect()->route('policy.check.form')
                ->with('error', 'Policy not found. Please check and try again.');
        }
        if ($userAcc) {
            return back()->withErrors(['policy_number' => 'policy already have account created.']);
        }

        return view('auth.register', compact('policyData'));
    }

    // Step 4: Save user + linked policy data
    public function processRegistration(Request $request)
    {


        // Decrypt PAN
        $encryptedPan = $request->pan_no;
        $pan = $this->decrypt($encryptedPan);

        // Decrypt Password
        $encryptedPassword = $request->password;
        $password = $this->decrypt($encryptedPassword);
        // Decrypt confirm Password
        $encryptedConfirmPassword = $request->password_confirmation;
        $Confirmpassword = $this->decrypt($encryptedConfirmPassword);

        // If decryption fails, redirect back with error
        if (!$password) {
            return redirect()->back()->withErrors(['password' => 'Invalid or tampered password.'])->withInput();
        }
       return  $pan.$password. $Confirmpassword;

        // Merge decrypted password and confirm_password into the request
        // This is essential for validation rules like 'confirmed' to work properly
        $request->merge([
            'password' => $password,
            'password_confirmation' => $Confirmpassword // assuming confirm password is encrypted same way and you want to validate it matches
        ]);
        // dd($request);
        $validated = $request->validate([

            'authorised_person_email' => 'required|email|unique:users,email',
            'industry_email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',

            'authorised_person_name' => 'required|string|max:255',
            'authorised_person_designation' => 'required|string|max:255',
            'estd_year' => 'required|integer|min:0000|max:' . date('Y'),

            'chemicals' => 'required|array',
            // 'chemicals.*' => 'exists:user_details,id',

        ], [
            'authorised_person_email.required' => 'The email field is required.',
            'authorised_person_email.email' => 'Please enter a valid email address.',
            'authorised_person_email.unique' => 'This email is already registered.',

            'industry_email.required' => 'The email field is required.',
            'industry_email.email' => 'Please enter a valid email address.',
            'industry_email.unique' => 'This email is already registered.',

            'password.required' => 'The password field is required.',
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'Password must be at least 8 characters.',

            'authorised_person_name.required' => 'The name field is required.',
            'authorised_person_name.string' => 'The name must be a string.',
            'authorised_person_name.max' => 'The name may not be greater than 255 characters.',

            'authorised_person_designation.required' => 'The designation field is required.',
            'authorised_person_designation.string' => 'The designation must be a string.',
            'authorised_person_designation.max' => 'The designation may not be greater than 255 characters.',

            'estd_year.required' => 'The established year field is required.',
            'estd_year.integer' => 'The established year must be a number.',
            'estd_year.min' => 'The established year must be at least 1900.',
            'estd_year.max' => 'The established year cannot be in the future.',

            'chemicals.required' => 'Please select at least one chemical.',
            'chemicals.array' => 'Invalid chemicals format.',
        ]);



        // $validated->failed
        // return $password;

        //dd($request);
        // $policyData = IndustryMasterData::where('policy_number', $request->policy)->firstOrFail();

        /* $user = User::create([
            'firstname'  => $request->firstname,
            'lastname'  => $request->lastname,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'role_type ' => $request->role_type,
            'password' => Hash::make($request->password),
            'industry_id'        => $policyData->id,
            'policy_number'      => $policyData->policy_number,
            'industry_name'      => $policyData->name_of_insured_owner,
            'insured_company_id' => $policyData->insured_company_id,
            'industry_address' => $policyData->address,
            'industry_city'          => $policyData->territorial_limits_district,
            'industry_state'         => $policyData->territorial_limits_state,

        ]);
        */
        //jalaj on 2-09-2025
        $user = User::create([
            'firstname'             => $request->industry_name,
            // 'lastname'              => $request->lastname,
            // 'industry_name'              => $request->industry_name,
            'mobile_no'             => $request->mobile_no,
            'email'                 => strtolower($request->industry_email),
            'role_type'             => 3,
            'password'              => $password,
            'company_gst'            => $request->company_gst,
            // 'pan_no'                 => $request->pan_no,
            'pan_no'                 => $pan,
            // 'industry_address_line1' => $policyData->address,
            // 'industry_city'          => $policyData->territorial_limits_district,
            // 'industry_state'         => $policyData->territorial_limits_state,
            // 'industry_pincode'       => $request->industry_pincode,
            // 'chemical_stored_list'   => json_encode($request->chemical_stored_list),
        ]);


        $userDetail = UserDetail::create([
            'name'             => $request->industry_name,
            'user_id'              => $user->id,
            'user_role_id'              => 3,
            'authorised_person_name'  => $request->authorised_person_name,
            'authorised_person_email'  => $request->authorised_person_email,
            'authorised_person_designation'  => $request->authorised_person_designation,
            'established_year'  => $request->estd_year,
            'mobile'             => $request->mobile_no,
            'state_id'             => $request->state,
            'district_id'             => $request->district,
            'locality'             => $request->locality,
            'pincode'             => $request->industry_pincode,
            'gst'            => $request->company_gst,
            'pan_no'                 => $request->pan_no,
            'chemical_stored_list_id'   => json_encode($request->chemicals),
        ]);
        // return $request->all();
        // Send welcome email
        // Mail::to($user->email)->send(new WelcomeUserMail($user));

        // dd($user);

        //auth()->login($user);
        return redirect()->intended('/login')->with('success', 'Registration successful!');
    }
    public function sendOtp(request $request)
    {
        // return $request->all();
        // return [$request->mobile_no];
        if (!isset($request->mobile) && $request->mobile == '') {
            // dd($request->mobile);
            return back()->withErrors(['mobile_no' => 'mobile no required.']);
        }
        $otpService = new OtpService();
        $response = $otpService->RegGenerateAndSendOtp($request->mobile, $request->email);
        if ($response == true)
            return  response()->json(["success" => true, "message" => "OTP sent successfully"]);
        else
            return false;
    }
    public function RegverifyOtp(Request $request)
    {
        $otp = $request->input('otp');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        // $policy = $request->input('policy');

        $cacheKey = "otp_" . md5($mobile . $email);

        $encryptedOtp = Cache::get($cacheKey);

        if (!$encryptedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired or not found'
            ]);
        }

        try {
            // decrypt stored OTP
            $cachedOtp = Crypt::decryptString($encryptedOtp);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP data (corrupted or tampered).'
            ]);
        }

        if ($otp == $cachedOtp) {
            // OTP is correct → mark as verified
            Cache::forget($cacheKey); // remove OTP after successful verification

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP'
        ]);
    }


    public function decrypt($encrypted)
    {
        $random_session_id1 = Session::get('random_session_id1');
        $random_session_id2 = Session::get('random_session_id2');

        // echo $random_session_id2;

        $key = hex2bin("0123456789abcdef0123456789abcdef");
        $iv = hex2bin("abcdef9876543210abcdef9876543210");

        // $encrypted = trim($encrypted);  // Trim any hidden whitespace
        // echo $encrypted;
        $encrypted = base64_decode($encrypted);
        // echo $encrypted;
        // $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, OPENSSL_ZERO_PADDING, $iv);
        $decrypted = openssl_decrypt($encrypted, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);

        $acNo = trim($decrypted);
        $acNo =  str_replace($random_session_id1, "", $acNo);
        $acNo =  str_replace($random_session_id2, "", $acNo);

        return $acNo;

        // Fix: Salt order from JS is session2 + acct_no + session1
        // $prefix = $random_session_id2;
        // $suffix = $random_session_id1;

        // echo $prefix . '<br>' ;
        // echo $suffix. '<br>' ;
        // echo $decrypted . '<br>' ;

        // if (str_starts_with($decrypted, $prefix) && str_ends_with($decrypted, $suffix)) {
        //     return substr($decrypted, strlen($prefix), -strlen($suffix));
        // }

        // Log::info("Decrypted output: " . $decrypted);
        // Log::info("Expected prefix: " . $prefix);
        // Log::info("Expected suffix: " . $suffix);

        // return null;
    }
<<<<<<< Updated upstream
=======

    //by jalaj on 7-10-2025 for insurance company registration
      // Show Insurance form
    public function showInsuranceForm()
    {
        return view('insurance.register');
    }

    // Handle Insurance registration
     /**
     * Handle Insurance Company Registration
     */
    public function registerInsurance(Request $request)
    {
        $request->validate([
            'industry_name' => 'required|string|max:255',
            'pan_no' => 'required|string|size:10|unique:users,pan_no',
            'company_gst' => 'nullable|string|max:15',
            'estd_year' => 'required|digits:4',
            'locality' => 'required|string|max:255',
            'state' => 'required|string',
            'district' => 'required|string',
            'industry_pincode' => 'required|digits:6',
            'authorised_person_name' => 'required|string|max:255',
            'authorised_person_designation' => 'required|string|max:100',
            'authorised_person_email' => 'required|email|max:255',
            'mobile_no' => 'required|digits_between:10,15',
            'industry_email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'captcha' => 'required|captcha'
        ]);

        // Create the user
        User::create([
            'name' => $request->industry_name,
            'email' => $request->industry_email,
            'password' => Hash::make($request->password), // ✅ server-side hashing
            'contact_no' => $request->mobile_no,
            'state_code' => $request->state,
            'district_id' => $request->district,
            'pan_no' => strtoupper($request->pan_no),
            'gst_no' => $request->company_gst,
            'role_type' => 4, // static for Insurance Company
        ]);

        return redirect()->route('insurance.register')->with('success', 'Insurance company registered successfully!');
    }

    // by jalaj gst by pass *******************************************
    /**
     * Get JWT token from FastAPI and cache it
     */
    private function getFastApiToken()
    {
        $cacheKey = env('FASTAPI_TOKEN_CACHE_KEY', 'fastapi_token');
        $ttl = (int) env('FASTAPI_TOKEN_TTL', 6600); // 110 mins

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $fastApiUrl = rtrim(env('FASTAPI_URL'), '/');

        try {
            $response = Http::timeout(5)->get($fastApiUrl . '/generate-token');
            if ($response->successful()) {
                $token = $response->json('access_token');
                Cache::put($cacheKey, $token, $ttl);
                return $token;
            }
        } catch (\Exception $e) {
            \Log::error('FastAPI token fetch failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Verify GST number using FastAPI microservice
     */
    public function verifyGst(Request $request)
    {
        $gst = strtoupper(trim($request->input('gst')));
        if (!$gst) {
            return response()->json(['error' => 'GST is required'], 422);
        }

        $token = $this->getFastApiToken();
        if (!$token) {
            return response()->json(['error' => 'Unable to fetch FastAPI token'], 500);
        }

        $fastApiUrl = rtrim(env('FASTAPI_URL'), '/');

        try {
            $resp = Http::withToken($token)->timeout(6)->get($fastApiUrl . '/verify/' . $gst);
        } catch (\Exception $e) {
            return response()->json(['error' => 'FastAPI not reachable', 'message' => $e->getMessage()], 502);
        }

        if ($resp->status() === 200) {
            return response()->json(['success' => true, 'data' => $resp->json()]);
        } elseif ($resp->status() === 404) {
            return response()->json(['success' => false, 'message' => 'GST not found'], 404);
        } else {
            return response()->json(['error' => 'Unexpected FastAPI error', 'status' => $resp->status()], 500);
        }
    }


>>>>>>> Stashed changes
}
