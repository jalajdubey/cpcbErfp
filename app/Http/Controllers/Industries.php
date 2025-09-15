<?php

namespace App\Http\Controllers;
use App\Models\OtpVerification;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Cities;
use App\Models\User; // Assuming you're using the User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailotpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Services\LocationService;
class Industries extends Controller
{
    //
    protected $locationService;
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    public function getStates()
    {
        return response()->json($this->locationService->getAllStates());
    }

    public function getDistricts($stateId)
    {
        return response()->json($this->locationService->getDistrictsByStateId($stateId));
    }

//send otp on 
public function sendEmailOtp(Request $request)
{
    $request->validate(['company_email' => 'required|email']);
    $otp = rand(100000, 999999);

    OtpVerification::updateOrCreate(
        ['email' => $request->company_email],
        ['otp' => $otp, 'expires_at' => now()->addMinutes(10), 'verified' => false]
    );

    Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
        $message->to($request->company_email)->subject('Company Email OTP');
    });

    return response()->json(['status' => 'success', 'message' => 'OTP sent']);
}

public function verifyEmailOtp(Request $request)
{
    $request->validate([
        'company_email' => 'required|email',
        'otp' => 'required',
    ]);
     $email=$request->company_email;
    $otpRecord = OtpVerification::where('email', $email)
        ->where('otp', $request->otp)
        ->where('expires_at', '>', now())
        ->first();

        if ($otpRecord) {
            $otpRecord->update(['verified' => true]);
        
            return response()->json([
                'status' => 'success',
                'verified' => true, // <-- This is the key for your frontend JS
                'message' => 'OTP verified successfully!'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'verified' => false, // <-- In case OTP is not valid
                'message' => 'Invalid OTP!'
            ]);
        }
    }




    public function Industries()
    {
        
        // Fetch some data you want to show on dashboard, for example, the number of users
        $industryuser = Auth::user();
       // dd(  $user);
      
         // Ensure users are passed to the dashboard view
         return view('industries.dashboard');
       
    }
 public function profileSummary(){

    return view('industries.profilesummary');
 }

//gst validation

public function GetGstApi(Request $req)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);

        $gstno = $req->input('gst_no');

        $res = $client->get("http://103.7.181.103/gstapi/?gst_no=$gstno");
        $res->getStatusCode();
        $users = $res->getBody()->getContents();

        $array = json_decode($users, true);

        //print_r($array);

        return json_encode(
            array(
                "statusCode" => $res->getStatusCode(),
                'data' => $array
            )
        );

    }
}
