<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndustryMasterData;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\ApiKey;
use App\Models\DocumentsFile;
use App\Models\UploadedDocument;
use App\Models\BackupUploadedDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\DocumentUploadService;
use App\Services\DocumentUpdateService;
use App\Models\PolicyLookupLog;
use App\Services\PolicyUpdateService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Encryption\Encrypter;

class Insurance extends Controller
{





    public function policydata(Request $request): JsonResponse
    {
        //$records = $this->decryptPayload($request->input('records'));

        $recordsInput = $request->input('records');
        // dd($recordsInput);
        if (is_string($recordsInput)) {
            // assume encrypted string
            $records = $this->decryptPayload($recordsInput);
        } else {
            // already plain array/object
            $records = $recordsInput;
        }

        if (!is_array($records)) {
            return response()->json([
                'message' => 'Invalid records format. Expected an array of records.'
            ], 400);
        }

        if (count($records) > 10) {
            return response()->json([
                'message' => 'No more than 10 records are allowed per batch'
            ], 400);
        }

        $batchReferenceId = 'BATCH-' . now()->format('YmdHis') . Str::random(5);
        $token = $request->header('X-API-TOKEN');
        if (!$token) {
            return response()->json(['message' => 'API Token is required'], 401);
        }

        $tokenRecord = ApiKey::where('api_key', $token)->where('active', true)->first();
        if (!$tokenRecord) {
            return response()->json(['message' => 'Invalid or inactive API token'], 401);
        }

        $userId = $tokenRecord->user_id;
        if (!$userId) {
            return response()->json([
                'message' => 'API Token does not match the expected user',
            ], 401);
        }

        DB::beginTransaction();
        $errors = [];

        foreach ($records as $index => $record) {
            $validator = Validator::make($record, [
                'insured_company_id' => 'nullable|string|max:255|regex:/^[A-Za-z0-9\s,;\/\\\\]+$/',
                'name_of_insurance_company' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
                'name_of_insured_owner' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
                'business_type' => 'required|string|max:255|regex:/^[A-Za-z\s\-\/]+$/',
                'address' => 'required|string|max:255|regex:/^[A-Za-z0-9\s\/\-,\"\'\;]+$/',
                'territorial_limits_district' => 'required|string|max:255|regex:/^[A-Za-z0-9\s&]+$/',
                'territorial_limits_state' => 'required|string|max:255|regex:/^[A-Za-z0-9\s&]+$/',
                'annual_turnover_cr' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'paid_up_capital_cr' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'policy_duration_year' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'policy_valid_upto' => 'required|date_format:Y-m-d|after_or_equal:2025-12-31',
                // 'indemnity_limit_rs' => 'numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'indemnity_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'premium_without_tax_rs' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'contribution_to_erf_rs' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                // 'any_one_year_limit_rs' => 'numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                // 'any_one_accident_limit_rs' => 'numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'any_one_year_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'any_one_accident_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
                'erf_deposit_utr_no' => 'required|string|max:255|regex:/^[A-Za-z0-9\/\-]+$/',
                'date_of_proposal' => 'required|date_format:Y-m-d',
                'date_of_erf_payment' => 'required|date_format:Y-m-d|after_or_equal:2025-01-01',
                'pan_of_company' => 'required|string|max:20|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i',
                'gst_of_company' => 'required|string|max:20|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                'email_of_company' => 'nullable|email|max:255',
                'mobile_of_company' => 'nullable|string|min:10|max:16|regex:/^[0-9]+$/',
                'policy_number' => 'required|string|max:255|regex:/^[A-Za-z0-9\/\-]+$/|unique:industry_master_data,policy_number',
                'date_of_policy' => 'required|date_format:Y-m-d|after_or_equal:2025-01-01',
            ]);

            //addded at 9/6/2025
            $validator->after(function ($validator) use ($record) {
                $indemnity = isset($record['indemnity_limit_rs']) ? trim((string) $record['indemnity_limit_rs']) : null;
                $year = isset($record['any_one_year_limit_rs']) ? trim((string) $record['any_one_year_limit_rs']) : null;
                $accident = isset($record['any_one_accident_limit_rs']) ? trim((string) $record['any_one_accident_limit_rs']) : null;
                $proposalDate = $record['date_of_proposal'] ?? null;
                $policyDate = $record['date_of_policy'] ?? null;
                $erfPaymentDate = $record['date_of_erf_payment'] ?? null;

                $hasIndemnity = $indemnity !== '' && is_numeric($indemnity);
                $hasYear = $year !== '' && is_numeric($year);
                $hasAccident = $accident !== '' && is_numeric($accident);

                if (!$hasIndemnity) {
                    if (!$hasYear) {
                        $validator->errors()->add('any_one_year_limit_rs', 'This field is required when Indemnity Limit is not provided.');
                    }
                    if (!$hasAccident) {
                        $validator->errors()->add('any_one_accident_limit_rs', 'This field is required when Indemnity Limit is not provided.');
                    }
                }
                if ($proposalDate && $policyDate && strtotime($proposalDate) > strtotime($policyDate)) {
                    $validator->errors()->add('date_of_proposal', 'The date of proposal must be before or equal to the date of policy.');
                }
                if ($erfPaymentDate && $policyDate && strtotime($erfPaymentDate) < strtotime($policyDate)) {
                    $validator->errors()->add('erf_payment_date', 'The ERF Payment Date must be the same as or after the Policy Date.');
                }
            });

            //end 9/6/2025

            if ($validator->fails()) {
                $errors[] = [
                    'index' => $index,
                    'errors' => $validator->errors()->messages()
                ];
                Log::channel('daily')->error('Validation failed for record at index ' . $index, [
                    'errors' => $validator->errors()->messages(),
                    'record' => $record,
                    'batch_reference' => $batchReferenceId
                ]);
                continue;
            }

            //code of erf_utr number and date check at 04/6/2025




            $utr = $record['erf_deposit_utr_no'];
            $date = $record['date_of_erf_payment'];

            if (isset($utrDateMap[$utr]) && $utrDateMap[$utr] !== $date) {
                $errors[$index][] = "Inconsistent 'date_of_erf_payment' for UTR '{$utr}' within batch.";
            } else {
                $utrDateMap[$utr] = $date;
            }


            foreach ($utrDateMap as $utr => $date) {
                $dbConflict = DB::table('industry_master_data')
                    ->where('erf_deposit_utr_no', $utr)
                    ->where('date_of_erf_payment', '!=', $date)
                    ->exists();

                if ($dbConflict) {
                    $errors[] = [
                        'index' => $index,
                        'errors' => [
                            'erf_deposit_utr_no' => ["UTR '{$utr}' already exists in database with a different date."]
                        ]
                    ];
                }
            }


            //end above code


            $record['batch_reference'] = $batchReferenceId;
            $record['user_id'] = $userId;

            try {
                IndustryMasterData::create($record);
            } catch (\Throwable $e) {
                Log::channel('daily')->error("DB insert error at index $index", [
                    'exception' => $e->getMessage(),
                    'record' => $record,
                    'batch_reference' => $batchReferenceId
                ]);

                $errors[] = [
                    'index' => $index,
                    'errors' => [
                        'database' => ['A system error occurred while saving this record. Please check your data or try again later.']
                    ]
                ];
                continue;
            }
        }

        if (!empty($errors)) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validation or processing errors occurred in one or more records',
                'errors' => $errors
            ], 422);
        }

        DB::commit();
        return response()->json([
            'message' => 'Batch data inserted successfully',
            'batch_reference' => $batchReferenceId
        ], 201);
    }




    public function encData(Request $request)
    {
        $customKey = 'base64:' . env('APP_ENCRYPT_KEY'); // or fetch from config/DB
        $rawKey    = base64_decode(substr($customKey, 7));
        $encrypter = new Encrypter($rawKey, config('app.cipher'));

        $encdata = $request->records;
        $encrypted = $encrypter->encrypt($encdata);
        return $encrypted;
    }





    public function decryptPayload($encryptedPayload)
    {
        // dd($encryptedPayload);
        $customKey = 'base64:' . env('APP_ENCRYPT_KEY'); // or fetch from config/DB
        $rawKey    = base64_decode(substr($customKey, 7));
        $encrypter = new Encrypter($rawKey, config('app.cipher'));

        $plaintext = $encryptedPayload;
        // $encrypted = $encrypter->encrypt($plaintext);

        // 4) Decrypt it back
        $decrypted = $encrypter->decrypt($plaintext);

        return $decrypted;
    }



    //add 24-4-2025 for status update

    // public function updatePolicyData(Request $request): JsonResponse
    // {
    //     $records = $request->input('records');

    //     // Step 1: Validate API Token
    //     $token = $request->header('X-API-TOKEN');
    //     if (!$token) {
    //         return response()->json(['message' => 'API Token is required'], 401);
    //     }

    //     $tokenRecord = ApiKey::where('api_key', $token)->where('active', true)->first();
    //     if (!$tokenRecord) {
    //         return response()->json(['message' => 'Invalid or inactive API token'], 401);
    //     }

    //     $userId = $tokenRecord->user_id;

    //     // Step 2: Validate payload
    //     if (!is_array($records) || count($records) === 0) {
    //         return response()->json(['message' => 'The records array is required and must contain at least one item.'], 422);
    //     }

    //     // Step 3: Generate a batch reference
    //     $batchReferenceId = 'BATCH-' . now()->format('YmdHis') . Str::upper(Str::random(5));

    //     $updated = [];
    //     $unchanged = [];
    //     $notFound = [];
    //     $errors = [];

    //     DB::beginTransaction();

    //     try {
    //         foreach ($records as $index => $data) {
    //             // Step 4: Validate individual record
    //             $validator = Validator::make($data, [
    //                 'insured_company_id' => 'required|string|max:255',
    //                 'policy_number' => 'required|string|max:255',
    //                 'date_of_policy' => ['nullable', 'date', 'after_or_equal:2025-01-01'],
    //             ]);

    //             if ($validator->fails()) {
    //                 $errors[] = [
    //                     'index' => $index,
    //                     'policy_number' => $data['policy_number'] ?? null,
    //                     'insured_company_id' => $data['insured_company_id'] ?? null,
    //                     'errors' => $validator->errors()->messages()
    //                 ];
    //                 continue;
    //             }

    //             // Step 5: Fetch existing record
    //             $existing = IndustryMasterData::where('user_id', $userId)
    //                 ->where('policy_number', $data['policy_number'])
    //                 ->where('insured_company_id', $data['insured_company_id'])
    //                 ->first();

    //             if (!$existing) {
    //                 $notFound[] = [
    //                     'index' => $index,
    //                     'policy_number' => $data['policy_number'],
    //                     'insured_company_id' => $data['insured_company_id'],
    //                     'error' => "No matching record found for Policy Number '{$data['policy_number']}' and Insured Company ID '{$data['insured_company_id']}' under your account."
    //                 ];
    //                 continue;
    //             }

    //             // Step 6: Detect changes
    //             $changes = [];
    //             foreach ($data as $key => $value) {
    //                 if (!in_array($key, ['user_id', 'policy_number', 'insured_company_id']) &&
    //                     isset($existing->$key) &&
    //                     $existing->$key != $value) {
    //                     $changes[$key] = $value;
    //                 }
    //             }

    //             if (empty($changes)) {
    //                 $unchanged[] = [
    //                     'index' => $index,
    //                     'policy_number' => $data['policy_number'],
    //                     'message' => 'No changes detected for this record.'
    //                 ];
    //                 continue;
    //             }

    //             // Step 7: Backup original record with existing + new batch reference
    //             $backupData = $existing->toArray();
    //             $backupData['original_batch_reference'] = $existing->batch_reference ?? null;
    //             $backupData['batch_reference'] = $batchReferenceId;
    //             unset($backupData['id']);

    //             \App\Models\IndustryMasterDataBackup::create($backupData);

    //             // Step 8: Update record
    //             foreach ($changes as $field => $value) {
    //                 $existing->$field = $value;
    //             }
    //             $existing->batch_reference = $batchReferenceId;
    //             $existing->is_updated = 1;
    //             $existing->save();

    //             $updated[] = [
    //                 'index' => $index,
    //                 'policy_number' => $data['policy_number'],
    //                 'updated_fields' => array_keys($changes),
    //                 'message' => 'Record updated successfully.'
    //             ];
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'message' => 'Bulk update processed.',
    //             'batch_reference' => $batchReferenceId,
    //             'updated' => $updated,
    //             'unchanged' => $unchanged,
    //             'not_found' => $notFound,
    //             'validation_errors' => $errors
    //         ], 200);

    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         // Log error to storage/logs/policy_update.log
    //         Log::channel('policy_update')->error('Bulk update failed', [
    //             'user_id' => $userId,
    //             'error' => $e->getMessage(),
    //             'records' => $records
    //         ]);

    //         return response()->json([
    //             'message' => 'Bulk update failed due to server error.',
    //             'error' => $e->getMessage(),
    //             'batch_reference' => $batchReferenceId,
    //             'updated' => $updated,
    //             'unchanged' => $unchanged,
    //             'not_found' => $notFound,
    //             'validation_errors' => $errors
    //         ], 500);
    //     }
    // }

    //udated code for update record without using services at 11-6-2025


    // public function updatePolicyData(Request $request): JsonResponse
    // {
    //     $records = $request->input('records');

    //     // Step 1: Validate API Token
    //     $token = $request->header('X-API-TOKEN');
    //     if (!$token) {
    //         return response()->json(['message' => 'API Token is required'], 401);
    //     }

    //     $tokenRecord = ApiKey::where('api_key', $token)->where('active', true)->first();
    //     if (!$tokenRecord) {
    //         return response()->json(['message' => 'Invalid or inactive API token'], 401);
    //     }

    //     $userId = $tokenRecord->user_id;

    //     // Step 2: Validate payload format
    //     if (!is_array($records) || count($records) === 0) {
    //         return response()->json(['message' => 'The records array is required and must contain at least one item.'], 422);
    //     }

    //     // Step 3: Validate all records before DB transaction
    //     $validationErrors = [];
    //     $notFound = [];
    //     $utrDateMap = [];

    //     foreach ($records as $index => $data) {
    //         $validator = Validator::make($data, [
    //             'insured_company_id' => 'required|string|max:255',
    //             'policy_number' => 'required|string|max:255',
    //             'date_of_policy' => ['nullable', 'date', 'after_or_equal:2025-01-01'],
    //             'name_of_insurance_company' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
    //             'name_of_insured_owner' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
    //             'business_type' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
    //             'address' => 'required|string|max:255|regex:/^[A-Za-z0-9\/\-\s]+$/',
    //             'territorial_limits_district' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
    //             'territorial_limits_state' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
    //             'annual_turnover_cr' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'paid_up_capital_cr' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'policy_duration_year' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'policy_valid_upto' => 'required|date_format:Y-m-d|after_or_equal:2025-12-31',
    //             'indemnity_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'premium_without_tax_rs' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'contribution_to_erf_rs' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'any_one_year_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'any_one_accident_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
    //             'erf_deposit_utr_no' => 'required|string|max:255|regex:/^[A-Za-z0-9\/\-]+$/',
    //             'date_of_proposal' => 'required|date_format:Y-m-d',
    //             'date_of_erf_payment' => 'required|date_format:Y-m-d|after_or_equal:2025-01-01',
    //             'pan_of_company' => 'required|string|max:20|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i',
    //             'gst_of_company' => 'required|string|max:20|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
    //             'email_of_company' => 'required|email|max:255',
    //             'mobile_of_company' => 'required|string|min:10|max:16|regex:/^[0-9]+$/',
    //         ]);

    //         // Custom validation logic
    //         $validator->after(function ($validator) use ($data) {
    //             $indemnity = trim((string) ($data['indemnity_limit_rs'] ?? ''));
    //             $year = trim((string) ($data['any_one_year_limit_rs'] ?? ''));
    //             $accident = trim((string) ($data['any_one_accident_limit_rs'] ?? ''));
    //             $proposalDate = $data['date_of_proposal'] ?? null;
    //             $policyDate = $data['date_of_policy'] ?? null;
    //             $erfPaymentDate = $data['date_of_erf_payment'] ?? null;

    //             if ($indemnity === '' || !is_numeric($indemnity)) {
    //                 if ($year === '' || !is_numeric($year)) {
    //                     $validator->errors()->add('any_one_year_limit_rs', 'This field is required when Indemnity Limit is not provided.');
    //                 }
    //                 if ($accident === '' || !is_numeric($accident)) {
    //                     $validator->errors()->add('any_one_accident_limit_rs', 'This field is required when Indemnity Limit is not provided.');
    //                 }
    //             }

    //             if ($proposalDate && $policyDate && strtotime($proposalDate) > strtotime($policyDate)) {
    //                 $validator->errors()->add('date_of_proposal', 'The date of proposal must be before or equal to the date of policy.');
    //             }

    //             if ($erfPaymentDate && $policyDate && strtotime($erfPaymentDate) < strtotime($policyDate)) {
    //                 $validator->errors()->add('erf_payment_date', 'The ERF Payment Date must be the same as or after the Policy Date.');
    //             }
    //         });

    //         if ($validator->fails()) {
    //             $validationErrors[] = [
    //                 'index' => $index,
    //                 'policy_number' => $data['policy_number'] ?? null,
    //                 'insured_company_id' => $data['insured_company_id'] ?? null,
    //                 'errors' => $validator->errors()->messages(),
    //             ];
    //             continue;
    //         }

    //         // Record existence check
    //         $exists = IndustryMasterData::where('user_id', $userId)
    //             ->where('policy_number', $data['policy_number'])
    //             ->where('insured_company_id', $data['insured_company_id'])
    //             ->exists();

    //         if (!$exists) {
    //             $notFound[] = [
    //                 'index' => $index,
    //                 'policy_number' => $data['policy_number'] ?? null,
    //                 'insured_company_id' => $data['insured_company_id'] ?? null,
    //                 'error' => 'No matching record found.'
    //             ];
    //         }
    //     }

    //    
    //     if (!empty($validationErrors) || !empty($notFound)) {
    //         Log::channel('policy_update_validation')->error('Policy data validation failed', [
    //             'user_id' => $userId,
    //             'validation_errors' => $validationErrors,
    //             'not_found' => $notFound
    //         ]);

    //         return response()->json([
    //             'message' => 'Validation failed. No records were updated.',
    //             'validation_errors' => $validationErrors,
    //             'not_found' => $notFound,
    //         ], 422);
    //     }

    //     
    //     DB::beginTransaction();

    //     $updated = [];
    //     $unchanged = [];

    //     try {
    //         $batchReferenceId = 'BATCH-' . now()->format('YmdHis') . strtoupper(Str::random(5));

    //         foreach ($records as $index => $data) {
    //             $existing = IndustryMasterData::where('user_id', $userId)
    //                 ->where('policy_number', $data['policy_number'])
    //                 ->where('insured_company_id', $data['insured_company_id'])
    //                 ->first();

    //             $changes = [];
    //             foreach ($data as $key => $value) {
    //                 if (
    //                     !in_array($key, ['user_id', 'policy_number', 'insured_company_id']) &&
    //                     isset($existing->$key) &&
    //                     $existing->$key != $value
    //                 ) {
    //                     $changes[$key] = $value;
    //                 }
    //             }

    //             if (empty($changes)) {
    //                 $unchanged[] = [
    //                     'index' => $index,
    //                     'policy_number' => $data['policy_number'],
    //                     'message' => 'No changes detected for this record.'
    //                 ];
    //                 continue;
    //             }

    //             // Backup
    //             $backupData = $existing->toArray();
    //             $backupData['original_batch_reference'] = $existing->batch_reference ?? null;
    //             $backupData['batch_reference'] = $batchReferenceId;
    //             unset($backupData['id']);
    //             \App\Models\IndustryMasterDataBackup::create($backupData);

    //             // Update
    //             foreach ($changes as $field => $value) {
    //                 $existing->$field = $value;
    //             }
    //             $existing->batch_reference = $batchReferenceId;
    //             $existing->is_updated = 1;
    //             $existing->save();

    //             $updated[] = [
    //                 'index' => $index,
    //                 'policy_number' => $data['policy_number'],
    //                 'updated_fields' => array_keys($changes),
    //                 'message' => 'Record updated successfully.'
    //             ];
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'message' => 'Bulk update processed successfully.',
    //             'batch_reference' => $batchReferenceId,
    //             'updated' => $updated,
    //             'unchanged' => $unchanged
    //         ], 200);

    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         Log::channel('policy_update')->error('Bulk update failed', [
    //             'user_id' => $userId,
    //             'error' => $e->getMessage(),
    //             'records' => $records
    //         ]);

    //         return response()->json([
    //             'message' => 'Bulk update failed due to server error.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // modify code using services at 11-6-2024
    public function updatePolicyData(Request $request, PolicyUpdateService $service): JsonResponse
    {
        // $records = $request->input('records');
        $records = $this->decryptPayload($request->input('records'));
        $token = $request->header('X-API-TOKEN');

        return $service->process($records, $token);
    }



    //upload document services call at 25-04-2025

    public function upload(Request $request, DocumentUploadService $service)
    {
        return $service->handleUpload($request);
    }





    //updated upload document at 25-4-2025

    public function updateUploadedDocument(Request $request, DocumentUpdateService $service)
    {

        return $service->handleUpdate($request);
    }

    public function getByPolicyNumberforuser(Request $request)
    {
        DB::beginTransaction();

        try {
            $policy_number = $request->input('policy_number'); // Use underscore
            $client_ip = $request->ip();

            if (!$policy_number) {
                PolicyLookupLog::create([
                    'policy_number' => null,
                    'requested_ip' => $client_ip,
                    'status' => 'invalid_request',
                    'message' => 'Policy number is required.'
                ]);
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Policy number is required.'
                ], 400);
            }

            $data = IndustryMasterData::with([
                'apiKey:id,user_id,name_of_general_insurance_company',
                'uploadedDocuments:id,policy_number,file_path'
            ])->where('policy_number', $policy_number)->first();

            if (!$data) {
                PolicyLookupLog::create([
                    'policy_number' => $policy_number,
                    'requested_ip' => $client_ip,
                    'status' => 'not_found',
                    'message' => 'Policy not found.'
                ]);
                DB::commit();

                return response()->json([
                    'status' => false,
                    'message' => 'Policy not found.'
                ], 404);
            }

            // Log successful access
            PolicyLookupLog::create([
                'policy_number' => $policy_number,
                'requested_ip' => $client_ip,
                'status' => true,
                'message' => 'Policy found and returned.'
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            PolicyLookupLog::create([
                'policy_number' => $request->input('policy_number'),
                'requested_ip' => $request->ip(),
                'status' => false,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'An internal error occurred.'
            ], 500);
        }
    }
}
