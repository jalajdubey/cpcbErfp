<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Insurance;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Industries;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware(['validate.api.access'])->group(function () {
    Route::post('/policy-data', [Insurance::class, 'policydata']);
    Route::post('/update-policy-data', [Insurance::class, 'updatePolicyData']);
    Route::post('/upload', [Insurance::class, 'upload']);
    Route::post('/update-upload', [Insurance::class, 'updateUploadedDocument']);
});
// Route::post('/policynumber', [Insurance::class, 'getByPolicyNumberforuser'])
//     ->middleware('static.token'); // Optional, only if token protection is needed
Route::post('/policynumber', [Insurance::class, 'getByPolicyNumberforuser']);

Route::get("encdata", [Insurance::class, 'encData']);
Route::get('/states', [Industries::class, 'getStates']);
Route::get('/districts/{stateId}', [Industries::class, 'getDistricts']);
