<?php

namespace App\Services;

use App\Models\ApiKey;
use App\Models\IndustryMasterData;
use App\Models\IndustryMasterDataBackup;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\DocumentsFile;
use Illuminate\Support\Str;

class PolicyUpdateService
{

    public function process(array $records, string $token): JsonResponse
    {
        // ✅ Step 1: Validate API Token
        $tokenRecord = ApiKey::where('api_key', $token)->where('active', true)->first();
        if (!$tokenRecord) {
            return response()->json(['message' => 'Invalid or inactive API token'], 401);
        }

        $userId = $tokenRecord->user_id;

        if (empty($records)) {
            return response()->json(['message' => 'Records array is empty'], 422);
        }

        $validationErrors = [];
        $notFound = [];
        $utrDateMap = [];

        // ✅ Step 2: Validate each record
        foreach ($records as $index => $data) {
            $validator = Validator::make($data, $this->rules());

            $validator->after(function ($validator) use ($data) {
                $this->customValidations($validator, $data);
            });

            if ($validator->fails()) {
                $validationErrors[] = [
                    'index' => $index,
                    'policy_number' => $data['policy_number'] ?? null,
                    'insured_company_id' => $data['insured_company_id'] ?? null,
                    'errors' => $validator->errors()->messages(),
                ];
                continue;
            }

            // ✅ Find existing record by user_id and policy_number (not insured_company_id)
            $existing = IndustryMasterData::where('user_id', $userId)
                ->where('policy_number', $data['policy_number'])
                ->first();

            if (!$existing) {
                $notFound[] = [
                    'index' => $index,
                    'policy_number' => $data['policy_number'] ?? null,
                    'insured_company_id' => $data['insured_company_id'] ?? null,
                    'error' => 'No matching record found.'
                ];
                continue;
            }

            // ✅ Step 3: UTR-Date conflict check within batch
            $utr = $data['erf_deposit_utr_no'];
            $paymentDate = $data['date_of_erf_payment'];

            if (isset($utrDateMap[$utr]) && $utrDateMap[$utr] !== $paymentDate) {
                $validationErrors[] = [
                    'index' => $index,
                    'policy_number' => $data['policy_number'],
                    'insured_company_id' => $data['insured_company_id'],
                    'errors' => [
                        'erf_deposit_utr_no' => [
                            "Inconsistent ERF Payment Date for UTR '{$utr}' within the request batch."
                        ]
                    ]
                ];
                continue;
            }

            $utrDateMap[$utr] = $paymentDate;

            // ✅ Step 4: Check for UTR-Date conflict in DB
            $dbConflict = IndustryMasterData::where('erf_deposit_utr_no', $utr)
                ->where('date_of_erf_payment', '!=', $paymentDate)
                ->exists();

            if ($dbConflict) {
                $validationErrors[] = [
                    'index' => $index,
                    'policy_number' => $data['policy_number'],
                    'insured_company_id' => $data['insured_company_id'],
                    'errors' => [
                        'erf_deposit_utr_no' => [
                            "UTR '{$utr}' already exists in the database with a different ERF Payment Date."
                        ]
                    ]
                ];
                continue;
            }
        }

        // ❌ Step 5: Stop if any record failed
        if (!empty($validationErrors) || !empty($notFound)) {
            return response()->json([
                'message' => 'Validation failed. No records updated.',
                'validation_errors' => $validationErrors,
                'not_found' => $notFound,
            ], 422);
        }

        // ✅ Step 6: Begin DB transaction
        DB::beginTransaction();

        $updated = [];
        $unchanged = [];

        try {
            $batchReferenceId = 'BATCH-' . now()->format('YmdHis') . strtoupper(Str::random(5));

            foreach ($records as $index => $data) {
                $existing = IndustryMasterData::where('user_id', $userId)
                    ->where('policy_number', $data['policy_number'])
                    ->first();

                $changes = $this->detectChanges($existing, $data);

                $insuredCompanyIdUpdated = false;

                // ✅ Update insured_company_id if changed
                if (
                    isset($data['insured_company_id']) &&
                    $data['insured_company_id'] !== null &&
                    $data['insured_company_id'] !== $existing->insured_company_id
                ) {
                    $existing->insured_company_id = $data['insured_company_id'];
                    $insuredCompanyIdUpdated = true;
                }

                // 🚫 Skip if nothing to update
                if (empty($changes) && !$insuredCompanyIdUpdated) {
                    $unchanged[] = [
                        'index' => $index,
                        'policy_number' => $data['policy_number'],
                        'message' => 'No changes detected.'
                    ];
                    continue;
                }

                // 💾 Backup existing data
                IndustryMasterDataBackup::create(array_merge(
                    $existing->toArray(),
                    [
                        'original_batch_reference' => $existing->batch_reference,
                        'batch_reference' => $batchReferenceId,
                    ]
                ));

                // 💾 Apply changes
                $existing->fill($changes);
                $existing->batch_reference = $batchReferenceId;
                $existing->is_updated = 1;
                $existing->save();

                $updatedFields = array_keys($changes);
                if ($insuredCompanyIdUpdated) {
                    $updatedFields[] = 'insured_company_id';
                }

                $updated[] = [
                    'index' => $index,
                    'policy_number' => $data['policy_number'],
                    'updated_fields' => $updatedFields,
                    'message' => 'Record updated.'
                ];
            }

            DB::commit();

            return response()->json([
                'message' => 'Bulk update processed.',
                'batch_reference' => $batchReferenceId,
                'updated' => $updated,
                'unchanged' => $unchanged,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::channel('policy_update')->error('Bulk update failed', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Bulk update failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }






    private function rules(): array
    {
        return [
            'insured_company_id' => 'nullable|string|max:255|regex:/^[A-Za-z0-9\s,;\/\\\\]+$/',
            'policy_number' => 'required|string|max:255',
            'date_of_policy' => 'nullable|date|after_or_equal:2025-01-01',
            'name_of_insurance_company' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'name_of_insured_owner' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'business_type' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'address' => 'required|string|max:255|regex:/^[A-Za-z0-9\s\/\-,\"\'\;]+$/',
            'territorial_limits_district' => 'required|string|max:255|regex:/^[A-Za-z0-9\s&]+$/',
            'territorial_limits_state' => 'required|string|max:255|regex:/^[A-Za-z0-9\s&]+$/',
            'annual_turnover_cr' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'paid_up_capital_cr' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'policy_duration_year' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'policy_valid_upto' => 'required|date_format:Y-m-d|after_or_equal:2025-12-31',
            'indemnity_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'premium_without_tax_rs' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'contribution_to_erf_rs' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'any_one_year_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'any_one_accident_limit_rs' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,3})?$/',
            'erf_deposit_utr_no' => 'required|string|max:255|regex:/^[A-Za-z0-9\/\-]+$/',
            'date_of_proposal' => 'required|date_format:Y-m-d',
            'date_of_erf_payment' => 'required|date_format:Y-m-d|after_or_equal:2025-01-01',
            'pan_of_company' => 'required|string|max:20|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i',
            'gst_of_company' => 'required|string|max:20|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'email_of_company' => 'nullable|email|max:255',
            'mobile_of_company' => 'nullable|string|min:10|max:16|regex:/^[0-9]+$/',
        ];
    }

    private function customValidations($validator, $data): void
    {
        $indemnity = trim((string) ($data['indemnity_limit_rs'] ?? ''));
        $year = trim((string) ($data['any_one_year_limit_rs'] ?? ''));
        $accident = trim((string) ($data['any_one_accident_limit_rs'] ?? ''));
        $proposalDate = $data['date_of_proposal'] ?? null;
        $policyDate = $data['date_of_policy'] ?? null;
        $erfPaymentDate = $data['date_of_erf_payment'] ?? null;

        if ($indemnity === '' || !is_numeric($indemnity)) {
            if ($year === '' || !is_numeric($year)) {
                $validator->errors()->add('any_one_year_limit_rs', 'This field is required when Indemnity Limit is not provided.');
            }
            if ($accident === '' || !is_numeric($accident)) {
                $validator->errors()->add('any_one_accident_limit_rs', 'This field is required when Indemnity Limit is not provided.');
            }
        }

        if ($proposalDate && $policyDate && strtotime($proposalDate) > strtotime($policyDate)) {
            $validator->errors()->add('date_of_proposal', 'Proposal date must not be after policy date.');
        }

        if ($erfPaymentDate && $policyDate && strtotime($erfPaymentDate) < strtotime($policyDate)) {
            $validator->errors()->add('erf_payment_date', 'ERF Payment Date must not be before Policy Date.');
        }
    }

    private function detectChanges($existing, $new): array
    {
        $changes = [];

        foreach ($new as $key => $val) {
            if (
                !in_array($key, ['user_id', 'policy_number',  'name_of_insurance_company']) &&
                isset($existing->$key) &&
                $existing->$key != $val
            ) {
                $changes[$key] = $val;
            }
        }

        return $changes;
    }
}
