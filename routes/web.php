<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Monitering;
use App\Http\Controllers\Industries;
use App\Http\Controllers\AdminInsurance;
use App\Http\Controllers\SecureFileController;

/*
/*
|--------------------------------------------------------------------------
| Web Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('home', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'homepage'])->name('home');
Route::get('/about', [HomeController::class, 'aboutpage'])->name('aboutus');
Route::get('/pilerf', [HomeController::class, 'pilpage'])->name('pilandErf');
Route::get('/actandRule', [HomeController::class, 'actpage'])->name('actandRule');
Route::get('/stakeholder', [HomeController::class, 'stakepage'])->name('stakeholder');
Route::get('/annualReport', [HomeController::class, 'annualauditpage'])->name('annualReport');
Route::get('/faqM', [HomeController::class, 'faqpage'])->name('faqM');
// Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
//Route::post('register', [AuthController::class, 'register'])->name('register');
//start registration at 26/8/2025

Route::get('/policy-check', [RegisterController::class, 'showPolicyForm'])->name('policy.check.form');
Route::post('/policy-check', [RegisterController::class, 'verifyPolicy'])->name('policy.check.verify');
Route::post('/policy-check/ajax', [RegisterController::class, 'ajaxPolicyLookup'])->name('policy.check.ajax');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');   // ?policy=...
Route::post('/register', [RegisterController::class, 'processRegistration'])->name('register.process');
// Route::post('/verify-otp', [RegisterController::class, 'sendOtp'])->name('verify-otp');
Route::post('/send-otp', [RegisterController::class, 'sendOtp'])->name('send-otp');
Route::post('/hverify-otp', [RegisterController::class, 'RegverifyOtp'])->name('ajax.verify-otp');






//new registration at end 26/8/2025
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('/reload-captcha', function () {
    return response()->json(['captcha' => captcha_img('flat')]);
});

Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend-otp');
Route::get('/verify-otp-page', function () {
    return view('auth.verify_otp', [
        'userId' => session('userId')  // Retrieve the user ID from the session
    ]);
})->name('verify-otp-page');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');


Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/captcha', [AuthController::class, 'createCaptcha']);
Route::post('/validate-captcha', [AuthController::class, 'validateCaptcha']);
/* password reset link*/

Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.forgot');



Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);

Route::middleware('auth')->group(function () {

    //otp verification
    Route::get('otp/login', [AuthController::class, 'login'])->name('otp.login');
    Route::post('otp/generate', [AuthController::class, 'generate'])->name('otp.generate');
    Route::get('otp/verification/{user_id}', [AuthController::class, 'verification'])->name('otp.verification');
    Route::post('otp/generate', [AuthController::class, 'loginWithOtp'])->name('otp.generate');






    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::middleware(['role:1'])->group(function () {
        Route::get('/userrole', [AdminController::class, 'index']);
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('adduser', [AdminController::class, 'adduser'])->name('admin.addnewuser');
        Route::get('getUser', [AdminController::class, 'getUserDetails'])->name('admin.getUser');
        Route::get('/admin/edit/{id}', [AdminController::class, 'editUser'])->name('admin.edituser');
        Route::put('/admin/update/{id}', [AdminController::class, 'updateUser'])->name('admin.updateuser');
        Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteuser');
        Route::get('/admin/login-attempts', [AdminController::class, 'loginAttempts']);
        // Route::get('/admin/insurance-details', [AdminController::class,'getInsuranceDetails'])->name('insurance-details');
        Route::get('/admin/insurance-summary', [AdminController::class, 'getInsuranceDetails'])
            ->name('insurance-summary');

        // You can add more routes related to the admin/user dashboard here
        Route::get('/admin/insurance-company/{company}', [AdminController::class, 'adminindex'])->name('admin.insurance-company');
        Route::get('/admin/insurance-company/{company}/data', [AdminController::class, 'getData'])->name('admin.insurance-company.data');
        Route::get('/admin/insurance-company/{company}/export/excel', [AdminController::class, 'exportExcel'])->name('admin.insurance-company.export.excel');
        Route::get('/policy-details/{policyNumber}/pdf', [AdminController::class, 'downloadPdf'])->name('policy.details.pdf');
        Route::get('/policy-details/{policyNumber}', [AdminController::class, 'showPolicy'])->where('policyNumber', '.*')->name('policy.details');

        Route::get('/insComplist', [AdminController::class, 'listofInsCompany'])->name('insComplist');
        Route::get('/erfcontsummary', [AdminController::class, 'listoferfContribution'])->name('erfcontsummary');

        //added at 2/6/2025
        Route::post('/fund-contribution/details/{encrypted}', [AdminController::class, 'fundcontributiondetails'])->name('fundcontribution.details.post');
        Route::get('/erf-data', [AdminController::class, 'getErfData'])->name('erf.data');
        Route::get('/erf-data/export/{type}', [AdminController::class, 'export'])->name('erf.export');
        Route::get('/get-utrs', [AdminController::class, 'getUtrNumbers'])->name('erf.get-utrs');
        Route::get('/erf/export/pdf-custom', [AdminController::class, 'exportCustomPdf'])->name('erf.export.custom-pdf');

        Route::get('/secure-file/{path}', [SecureFileController::class, 'download'])
            ->where('path', '.*') // ✅ this is required to support folders in {path}
            ->middleware('signed')
            ->name('secure.file.download');
    });

    Route::middleware(['role:2'])->group(function () {
        Route::get('/modashboard', [Monitering::class, 'index'])->name('monitoring.dashboard');
    });

    Route::middleware(['role:3'])->group(function () {
        Route::get('/userdashboard', [Industries::class, 'Industries'])->name('industries.dashboard');
        Route::post('validategst', [Industries::class, 'GetGstApi'])->name('validategst');
        Route::post('/email-send-otp', [Industries::class, 'sendEmailOtp'])->name('email.send.otp');;
        Route::post('/email-verify-otp', [Industries::class, 'verifyEmailOtp'])->name('email.verify.otp');
        Route::get('/states', [Industries::class, 'getStates'])->name('states');
        Route::get('/districts/{stateId}', [Industries::class, 'getDistricts'])->name('districts');

        //15052025  ........
        Route::get('/profilelist', [Industries::class, 'profileSummary'])->name('profilelist');
    });

    Route::middleware(['role:4'])->group(function () {
        Route::get('/insurance-dashboard', [AdminInsurance::class, 'AdminInsurance'])->name('insurance.dashboard');
        Route::get('/dashboard/export', [AdminInsurance::class, 'export'])->name('dashboard.export');
        Route::get('/dashboard/search', [AdminInsurance::class, 'liveSearch']);
        Route::get('/policy-detailsIns/{policy_number}', [AdminInsurance::class, 'getPolicyDetails']);
        Route::get('/export-pdf/{policy_number}', [AdminInsurance::class, 'exportPDF'])->name('export.pdf');
        Route::get('/company-policies/{company}', [AdminInsurance::class, 'showPolicies'])->name('company.policies');
        Route::get('/ajax/company-policies', [AdminInsurance::class, 'ajaxPolicies'])->name('ajax.company.policies');
    });
});
// Route::get('/userdashboard', [Usercontroller::class, 'UserDashboard'])->name('user.dashboard');
