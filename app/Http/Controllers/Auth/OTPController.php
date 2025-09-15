<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\OTPService;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOTP(Request $request)
    {
        $user = auth()->user();
        $this->otpService->generateOTP($user);
        return back()->with('status', 'OTP sent to your registered mobile number.');
    }

    public function verifyOTP(Request $request)
    {
        $user = auth()->user();
        if ($this->otpService->validateOTP($user, $request->otp)) {
            // Handle successful OTP verification
            return redirect()->route('home')->with('status', 'OTP verified successfully!');
        }
        return back()->withErrors('Invalid or expired OTP.');
    }
}

