<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndustryMasterData;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\ApiKey;

class Insurance extends Controller
{
    //


    // public function policydata(Request $request): JsonResponse
    // {
    //     // Validate incoming request
    //     try {
    //     // Validate the request
    //     $validatedData = $request->validate([
    //         'batch_reference' => 'required|string|max:255',
    //         'insured_company_id' => 'required|string|max:255|unique:industry_master_data,insured_company_id',
    //         'name_of_insured_owner' => 'required|string|max:255',
    //         'business_type' => 'required|string|max:255',
    //         'address' => 'required|string|max:255',
    //         'territorial_limits_district' => 'required|string|max:255',
    //         'territorial_limits_state' => 'required|string|max:255',
    //         'annual_turnover_cr' => 'required|numeric|min:0',
    //         'paid_up_capital_cr' => 'required|numeric|min:0',
    //         'policy_period_year' => 'required|integer|min:1',
    //         'policy_period_month' => 'required|integer|min:1',
    //         'indemnity_limit_rs' => 'required|numeric|min:0',
    //         'premium_without_tax_rs' => 'required|numeric|min:0',
    //         'contribution_to_erf_rs' => 'required|numeric|min:0',
    //         'date_of_proposal' => 'required|date',
    //         'declaration_link' => 'required|string|max:255',
    //         'payment_particulars' => 'required|string|max:255',
    //         'pan_of_company' => 'required|string|max:20',
    //         'gst_of_company' => 'required|string|max:20',
    //         'email_of_company' => 'required|email|max:255',
    //         'mobile_of_company' => 'required|string|max:20',
    //         'policy_number' => 'required|string|max:255|unique:industry_master_data,policy_number'
    //     ]);

    //     // Insert data into database
    //     $industryData = IndustryMasterData::create($validatedData);

    //     // Return success response
    //     return response()->json([
    //         'message' => 'Data inserted successfully',
    //         //'data' => $industryData
    //     ], 201);

    // } catch (ValidationException $e) {
    //     // Return validation errors in a structured format
    //     return response()->json([
    //         'message' => 'Validation failed',
    //         'errors' => $e->errors() // Returns an array of validation error messages
    //     ], 422);
    // } catch (\Exception $e) {
    //     // Return generic error response
    //     return response()->json([
    //         'message' => 'An error occurred while inserting data',
    //         'error' => $e->getMessage()
    //     ], 500);
    // }
    // }
    //     public function policydata(Request $request): JsonResponse
    // {





    //     try {
    //         // STEP 1: Validate token first
    //         $token = $request->header('X-API-TOKEN') ?? $request->input('token');
    //         $userid = $request->header('USER-ID') ?? $request->input('token');
    //      // $userid = $request->header('USER-ID');
    //        //dd($token);
    //         if (!$token) {
    //             return response()->json([
    //                 'message' => 'Token is required',
    //             ], 401);
    //         }

    //         // Lookup the token in your api_keys or otp_verifications table
    //         $tokenRecord = ApiKey::where('user_id', $userid)->where('api_key', $token)->where('active', true)->first();

    //         if (!$tokenRecord) {
    //             return response()->json([
    //                 'message' => 'Invalid or inactive token',
    //             ], 401);
    //         }

    //         // STEP 2: Validate incoming request fields
    //         $validatedData = $request->validate([
    //             'batch_reference' => 'required|string|max:255',
    //             'insured_company_id' => 'required|string|max:255|unique:industry_master_data,insured_company_id',
    //             'name_of_insured_owner' => 'required|string|max:255',
    //             'business_type' => 'required|string|max:255',
    //             'address' => 'required|string|max:255',
    //             'territorial_limits_district' => 'required|string|max:255',
    //             'territorial_limits_state' => 'required|string|max:255',
    //             'annual_turnover_cr' => 'required|numeric|min:0',
    //             'paid_up_capital_cr' => 'required|numeric|min:0',
    //             'policy_period_year' => 'required|integer|min:1',
    //             'policy_period_month' => 'required|integer|min:1',
    //             'indemnity_limit_rs' => 'required|numeric|min:0',
    //             'premium_without_tax_rs' => 'required|numeric|min:0',
    //             'contribution_to_erf_rs' => 'required|numeric|min:0',
    //             'date_of_proposal' => 'required|date',
    //             'declaration_link' => 'required|string|max:255',
    //             'payment_particulars' => 'required|string|max:255',
    //             'pan_of_company' => 'required|string|max:20',
    //             'gst_of_company' => 'required|string|max:20',
    //             'email_of_company' => 'required|email|max:255',
    //             'mobile_of_company' => 'required|string|max:20',
    //             'policy_number' => 'required|string|max:255|unique:industry_master_data,policy_number',
    //             'date_of_policy' => 'required|date|after_or_equal:2025-01-01',
    //             'user_id' =>'required|string|max:20'

    //         ]);

    //         // STEP 3: Insert data
    //         $industryData = IndustryMasterData::create($validatedData);

    //         return response()->json([
    //             'message' => 'Data inserted successfully',
    //         ], 201);

    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'message' => 'Validation failed',
    //             'errors' => $e->errors()
    //         ], 422);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => 'An error occurred while inserting data',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function policydata(Request $request): JsonResponse
    {
        try {
            // STEP 1: Get token from header
            $token = $request->header('X-API-TOKEN');

            if (!$token) {
                return response()->json([
                    'message' => 'API Token is required',
                ], 401);
            }

            // STEP 2: Lookup token and get associated user
            $tokenRecord = ApiKey::where('api_key', $token)->where('active', true)->first();

            if (!$tokenRecord) {
                return response()->json([
                    'message' => 'Invalid or inactive API token',
                ], 401);
            }

            // Retrieve the expected user ID from application context/session/etc.
            $expectedUserId = $tokenRecord->user_id;

            // Additional check: Ensure that the tokenRecord's user_id matches the expected user_id
            if ($tokenRecord->user_id !== $expectedUserId) {
                return response()->json([
                    'message' => 'API Token does not match the expected user',
                ], 401);
            }

            // STEP 3: Validate incoming data (user_id removed from validation)
            $validatedData = $request->validate([

                'batch_reference' => 'required|string|max:255',
                'insured_company_id' => 'required|string|max:255|unique:industry_master_data,insured_company_id|regex:/^[a-zA-Z0-9,\-_.\/\\\\\s]+$/',
                'name_of_insured_owner' => 'required|string|max:255',
                'business_type' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'territorial_limits_district' => 'required|string|max:255',
                'territorial_limits_state' => 'required|string|max:255',
                'annual_turnover_cr' => 'required|numeric|min:0',
                'paid_up_capital_cr' => 'required|numeric|min:0',
                'policy_period_year' => 'required|integer|min:1',
                'policy_period_month' => 'required|integer|min:1',
                'indemnity_limit_rs' => 'required|numeric|min:0',
                'premium_without_tax_rs' => 'required|numeric|min:0',
                'contribution_to_erf_rs' => 'required|numeric|min:0',
                'date_of_proposal' => 'required|date',
                'declaration_link' => 'required|string|max:255',
                'payment_particulars' => 'required|string|max:255',
                'pan_of_company' => 'required|string|max:20',
                'gst_of_company' => 'required|string|max:20',
                'email_of_company' => 'required|email|max:255',
                'mobile_of_company' => 'required|string|max:20',
                'policy_number' => 'required|string|max:255|unique:industry_master_data,policy_number',
                'date_of_policy' => 'required|date|after_or_equal:2025-01-01',
                'user_id' => 'required|string|max:20'

            ]);


            // STEP 4: Inject user_id from API key record into validated data
            $validatedData['user_id'] = $tokenRecord->user_id;

            // STEP 5: Save data
            IndustryMasterData::create($validatedData);

            return response()->json([
                'message' => 'Data inserted successfully',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while inserting data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
