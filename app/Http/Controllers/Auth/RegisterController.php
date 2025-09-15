<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cache;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\IndustryMasterData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\OtpService;
use Illuminate\Support\Facades\Crypt;


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

        return view('auth.policy-check');
    }

    // Non-AJAX fallback (optional)
    public function verifyPolicy(Request $request)
    {
        $request->validate(['policy_number' => 'required|string|max:150']);

        $policy = IndustryMasterData::where('policy_number', $request->policy_number)->first();
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
            return back()->withErrors(['policy_number'=> 'policy already have account created.']);
        }

        return view('auth.register', compact('policyData'));
    }

    // Step 4: Save user + linked policy data
    public function processRegistration(Request $request)
    {
        //dd($request);
        $request->validate([

            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'policy' => 'required|string'
        ]);

        //dd($request);
        $policyData = IndustryMasterData::where('policy_number', $request->policy)->firstOrFail();

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
            'firstname'             => $request->firstname,
            'lastname'              => $request->lastname,
            'mobile_no'             => $request->mobile_no,
            'email'                 => strtolower($request->email),
            'role_type'             => $request->role_type,
            'password'              => $request->password,
            'industry_id'            => $policyData->id,
            'policy_number'          => $policyData->policy_number,
            'industry_name'          => $policyData->name_of_insured_owner,
            'insured_company_id'     => $policyData->insured_company_id,
            'company_gst'            => $request->company_gst,
            'pan_no'                 => $request->pan_no,
            'industry_address_line1' => $policyData->address,
            'industry_city'          => $policyData->territorial_limits_district,
            'industry_state'         => $policyData->territorial_limits_state,
            'industry_pincode'       => $request->industry_pincode,
        ]);


        // dd($user);

        //auth()->login($user);
        return redirect()->intended('/login')->with('success', 'Registration successful!');
    }
    public function sendOtp(request $request){
        // return $request->all();
        // return [$request->mobile_no];
        if(!isset($request->mobile) && $request->mobile == ''){
            // dd($request->mobile);
            return back()->withErrors(['mobile_no' => 'mobile no required.']);
        }
        $otpService = new OtpService();
        $response = $otpService->RegGenerateAndSendOtp($request->mobile, $request->email, $request->policy);
        if($response == true)
            return  response()->json([ "success"=> true, "message"=> "OTP sent successfully" ]);
        else
            return false;
    }
    public function RegverifyOtp(Request $request)
    {
        $otp = $request->input('otp');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        $policy = $request->input('policy');

        $cacheKey = "otp_" . md5($mobile . $email . $policy);

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
}
