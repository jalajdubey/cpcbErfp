<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
//use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\LoginAttempt;
use App\Services\OtpService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Mail\OtpMail;
use App\Rules\RestrictPatternPassword;
use Illuminate\Support\Facades\Password; // For reset links
use Illuminate\Validation\Rules\Password as PasswordRule; // For validation rule

class AuthController extends Controller
{
    /**
     * Show the login form view
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login with rate limiting and account lockout after failed attempts
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ], [
            'captcha.required' => 'Captcha is required.',
            'captcha.captcha' => 'Captcha does not match. Please try again.'
        ]);

        $credentials = $request->only('email', 'password');
      

        $email = strtolower($request->input('email'));
        $ip = $request->ip();

        $cacheKey = "login_attempts:{$email}:{$ip}";
        $lockoutKey = "lockout:{$email}:{$ip}";

         try {
        if (Cache::has($lockoutKey)) {
            $secondsRemaining = Cache::get($lockoutKey) - time();
            $minutes = ceil($secondsRemaining / 60);
            return back()->withErrors(['email' => "Account locked. Try again in {$minutes} minute(s)."])->withInput();
        }

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $email)->first();

           if (!$user) {
                return back()->withErrors(['email' => 'User not found.'])->withInput();
            }

            // Clear failed attempts
            Cache::forget($cacheKey);
            Cache::forget($lockoutKey);

            // Log successful attempt
            LoginAttempt::create([
                'user_id' => $user->id,
                'email' => $email,
                'ip_address' => $ip,
                'status' => true,
                'attempted_at' => now(),
            ]);

            // Send OTP
            $otpService = new OtpService();
            $otpService->generateAndSendOtp($user); // <- uses user info here

            // Save user info in session for OTP verification step
            session([
                'otp_user_id' => $user->id,
                'otp_email' => $user->email,
                'otp_verified' => false,
            ]);

            return redirect()->route('verify-otp-page'); // OTP input form
        } else {
            // Log failed attempt
            LoginAttempt::create([
                'email' => $email,
                'ip_address' => $ip,
                'status' => false,
                'attempted_at' => now(),
            ]);

            $attempts = Cache::increment($cacheKey, 1);
            Cache::put($cacheKey, $attempts, now()->addMinutes(60));

            if ($attempts >= 3) {
                Cache::put($lockoutKey, time() + 3600, now()->addMinutes(60));
                Cache::forget($cacheKey);
                return back()->withErrors(['email' => 'Too many login attempts. Your account has been locked for 1 hour.'])->withInput();
            }

            return back()->withErrors(['email' => 'Invalid credentials. Attempts left: ' . (3 - $attempts)])->withInput();
        }
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.'])->withInput();
        }
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $userId = session('otp_user_id');
        //dd($userId);
        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please login again.']);
        }

        $user = User::find($userId);

        if (!$user) {
            return back()->withErrors(['otp' => 'User not found.']);
        }

        $otpService = new OtpService();

        if ($otpService->verifyOtp($user, $request->otp)) {
            Auth::login($user);
            $request->session()->regenerate();

            session()->forget(['otp_user_id', 'otp_email', 'otp_verified']);

            return $this->redirectBasedOnRole();
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
    }

    public function resendOtp(Request $request)
    {
        $userId = session('otp_user_id');

        if (!$userId) {
            return response()->json(['message' => 'Session expired. Please login again.'], 401);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Throttle OTP resend requests (30 seconds cooldown)
        if ($user->last_otp_sent_at && now()->diffInSeconds($user->last_otp_sent_at) < 30) {
            return response()->json(['message' => 'Please wait before resending OTP.'], 429);
        }

        // Generate and send OTP
        $otpService = new OtpService();
        $otpService->generateAndSendOtp($user);

        $user->last_otp_sent_at = now();
        $user->save();

        return response()->json(['message' => 'OTP has been resent successfully.']);
    }




    // public function resendOtp(Request $request)
// {
//     $userId = session('otp_user_id');

    //     if (!$userId) {
//         return response()->json(['message' => 'Session expired. Please login again.'], 401);
//     }

    //     $user = User::find($userId);

    //     if (!$user) {
//         return response()->json(['message' => 'User not found.'], 404);
//     }
//    $lastSent = Carbon::parse($user->last_otp_sent_at);
//     // Optional: Throttle resend
//    if ( $lastSent->diffInSeconds(now()) < 30) {
//     return response()->json(['message' => 'Please wait before resending OTP.'], 429);
// }

    //     // Resend OTP
//     $otpService = new OtpService();
//     $otpService->generateAndSendOtp($user);

    //     $user->last_otp_sent_at = now();
//     $user->save();

    //     return response()->json(['message' => 'OTP has been resent.']);
// }


    /**
     * Redirect user to appropriate dashboard based on role
     */
    private function redirectBasedOnRole()
    {

        if (!Auth::check()) {
            Log::info('User is not logged in.');
            return redirect()->route('login');
        }

        $role = Auth::user()->role_type;
        Log::info('Redirecting user with role: ' . $role);
        //dd(  $role );
        return match ($role) {
            '1' => redirect()->route('admin.dashboard'),
            '2' => redirect()->route('monitoring.dashboard'),
            '3' => redirect()->route('industries.dashboard'),
            '4' => redirect()->route('insurance.dashboard'),
            default => redirect()->route('industries.dashboard'),
        };
    }

    //otp verification



    /**
     * Return the authenticated user's data (for API)
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Respond with JWT token structure (if using JWT-based auth)
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Logout the user, invalidate session, and redirect
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Optionally invalidate JWT if used
        // JWTAuth::invalidate(JWTAuth::getToken());

        return redirect('/');
    }

    /*forgot password reset link*/
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle sending of the password reset link.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email');
        $throttleKey = 'password_reset_' . $email;

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            return back()->withErrors(['email' => __('Too many reset attempts. Please try again in one hour.')]);
        }

        // Send the password reset link.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            RateLimiter::hit($throttleKey, 60); // 3600 seconds = 1 hour
            return back()->with('status', __($status));
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    //update password

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }
    public function updatePassword(Request $request)
    {
        //dd($request);

        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'confirmed',
                'different:current_password', // current_password is the input name
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {

            return back()->withErrors(['current_password' => 'Your current password does not match our records.']);
        }

        // Check password history
        $passwordHistories = $user->passwordHistories()->take(5)->pluck('password'); // last 5 passwords
        foreach ($passwordHistories as $oldPassword) {
            if (Hash::check($request->new_password, $oldPassword)) {
                return back()->withErrors(['new_password' => 'Your new password cannot be the same as any of your previous passwords.']);
            }
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        //dd( $user->password);
        $user->save();

        // Store password in history
        $user->passwordHistories()->create([
            'password' => $user->password
        ]);

        return back()->with('status', 'Your password has been changed successfully.');
    }
    // captcha code here 




}
