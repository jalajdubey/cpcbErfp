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
use App\Models\IndustryChemical;
use App\Models\IndustryChemicalBackup;
use Illuminate\Support\Arr;
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

             // ✅ Normalize hazardous_chemicals before validation using Arr::wrap
            $hazardous_chemicals = Arr::wrap($data['hazardous_chemicals'] ?? []);
            $data['hazardous_chemicals'] = $hazardous_chemicals;

            $validator = Validator::make($data, $this->rules());

            $validator->after(function ($validator) use ($data) {

                $allowedUnits = ['kg', 'ton'];  // define allowed units
                $hazardous_chemicals = $data['hazardous_chemicals'] ?? [];
                $seenChemicalIds = [];

                foreach ($hazardous_chemicals as $index => $chemical) {
                    $id = $chemical['id'] ?? null;
                    $quantity = $chemical['quantity'] ?? null;
                    $unit = $chemical['unit'] ?? null;

                    // ✅ Check for duplicate IDs
                    if (in_array($id, $seenChemicalIds)) {
                        $validator->errors()->add("hazardous_chemicals.$index.id", "Duplicate chemical ID '{$id}' found at index $index. Each ID must be unique.");
                    } else {
                        $seenChemicalIds[] = $id;
                    }

                    if (is_null($id)) {
                        $validator->errors()->add("hazardous_chemicals.$index.id", "Chemical ID at index $index is required.");
                    }

                    if (!is_numeric($quantity) || $quantity <= 0) {
                        $validator->errors()->add("hazardous_chemicals.$index.quantity", "Quantity at index $index must be a number greater than 0.");
                    }

                    if (empty($unit)) {
                        $validator->errors()->add("hazardous_chemicals.$index.unit", "Unit at index $index is required.");
                    } elseif (!in_array(strtolower($unit), $allowedUnits)) {
                        $validator->errors()->add("hazardous_chemicals.$index.unit", "Unit '{$unit}' at index $index is invalid. Allowed: " . implode(', ', $allowedUnits));
                    }
                }
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
                // $existingChemicals = IndustryChemical::where('industry_master_data_id', $existing->id)
                //     ->first();

                // 🔁 Handle hazardous chemicals (new block)
                $existingChemicals = IndustryChemical::where('industry_master_data_id', $existing->id)->get();
                $changesChemicals = [];

                // ✅ 1. First detect changes and update/create chemicals
                foreach ($data['hazardous_chemicals'] as $incomingChemical) {
                    $existingChemical = $existingChemicals->firstWhere('chemical_stored_lists_id', $incomingChemical['id']);

                    if ($existingChemical) {
                        $chemicalChanges = $this->detectChemicalChanges($existingChemical, $incomingChemical);
                        if (!empty($chemicalChanges)) {
                            // Defer the backup until after $IndustryMasterDataBackup is available
                            $changesChemicals[] = [
                                'existing' => $existingChemical,
                                'changes' => $chemicalChanges,
                                'incoming' => $incomingChemical,
                                'is_update' => true
                            ];
                        }
                    } else {
                        $newChemical = new IndustryChemical([
                            'chemical_stored_lists_id' => $incomingChemical['id'],
                            'quantity' => $incomingChemical['quantity'],
                            'unit' => $incomingChemical['unit'],
                            'industry_master_data_id' => $existing->id,
                        ]);
                        $newChemical->save();

                        $changesChemicals[] = [
                            'created' => true,
                            'id' => $newChemical->id,
                            'incoming' => $incomingChemical,
                            'is_update' => false
                        ];
                    }
                }

                // return response()->json($changesChemicals);

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
                if (empty($changes) && !$insuredCompanyIdUpdated && empty($changesChemicals)) {
                    $unchanged[] = [
                        'index' => $index,
                        'policy_number' => $data['policy_number'],
                        'message' => 'No changes detected.'
                    ];
                    continue;
                }

                // 💾 Backup existing data
                // if (!empty($chemicalChanges)) {
                    $IndustryMasterDataBackup = IndustryMasterDataBackup::create(array_merge(
                        $existing->toArray(),
                        [
                            'original_batch_reference' => $existing->batch_reference,
                            'batch_reference' => $batchReferenceId,
                        ]
                    ));
                // }


                // ✅ Now you can back up the existing chemicals that are changing
                    foreach ($changesChemicals as $chem) {
                        if (!empty($chem['is_update']) && isset($chem['existing'])) {
                            $existingChemical = $chem['existing'];
                            $chemicalChanges = $chem['changes'];

                           // Only create backup if there are changes
                            if (!empty($chemicalChanges)) {
                                IndustryChemicalBackup::create(array_merge(
                                    $existingChemical->toArray(),
                                    [
                                        'industry_master_data_backups_id' => $IndustryMasterDataBackup->id,
                                        'industry_master_data_id' => $existing->id,
                                        'industry_chemicals_id' => $existingChemical->id,
                                    ]
                                ));

                                // Apply the changes only if there are changes
                                $existingChemical->fill($chemicalChanges);
                                $existingChemical->save();
                            }
                        }
                    }

                // if(isset($existingChemicals)&& $existingChemicals != ''){

                //     IndustryChemicalBackup::create(array_merge(
                //         $existingChemicals->toArray(),
                //         [
                //             'industry_master_data_backups_id' => $IndustryMasterDataBackup->id,
                //             'industry_master_data_id' => $existing->id,
                //             'industry_chemicals_id' => $existingChemicals->id,
                //         ]
                //     ));
                // }

                // 💾 Apply changes
                $existing->fill($changes);
                $existing->batch_reference = $batchReferenceId;
                $existing->is_updated = 1;
                $existing->save();

                // if ($existingChemicals) {
                //     $existingChemicals->fill($changesChemicals);
                //     $existingChemicals->industry_master_data_id = $existing->id;
                //     $existingChemicals->save();
                // } else {
                //     Log::error('IndustryChemical not found for update.', [
                //         'expected_id' => 55,  // whatever ID or identifier you're using
                //         'changes' => $changesChemicals
                //     ]);
                //     // Optionally: throw an exception or handle fallback logic
                // }


                // $updatedFields = array_merge(array_keys($changes), array_keys($changesChemicals));
                // if ($insuredCompanyIdUpdated) {
                //     $updatedFields[] = 'insured_company_id';
                // }

                                // ✅ Extract updated field names from chemicals
                $chemicalUpdatedFields = [];

                foreach ($changesChemicals as $chemChange) {
                    if (isset($chemChange['changes']) && is_array($chemChange['changes'])) {
                        $chemicalUpdatedFields = array_merge($chemicalUpdatedFields, array_keys($chemChange['changes']));
                    }
                }

                $updatedFields = array_merge(array_keys($changes), $chemicalUpdatedFields);

                if ($insuredCompanyIdUpdated) {
                    $updatedFields[] = 'insured_company_id';
                }

                // ✅ Ensure uniqueness
                $updatedFields = array_values(array_unique($updatedFields));

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
            'insured_company_id' => 'nullable|string|max:255',
            'policy_number' => 'required|string|max:255',
            'date_of_policy' => 'nullable|date|after_or_equal:2025-01-01',
            'name_of_insured_owner' => 'required|string|max:255|regex:/^[A-Za-z\s,\/]+$/',
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
            // 'pan_of_company' => 'required|string|max:20|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i',
            //'gst_of_company' => 'required|string|max:20|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'pan_of_company' => 'nullable|string|max:10',
            'gst_of_company' => 'nullable|string|max:15',
            'email_of_company' => 'nullable|email|max:255',
            'mobile_of_company' => 'nullable|string|min:10|max:16|regex:/^[0-9]+$/',
            'hazardous_chemicals' => 'required|array|min:1',
            'hazardous_chemicals.*.id' => 'integer|exists:chemical_stored_lists,id',
            'hazardous_chemicals.*.quantity' => 'numeric',
            'hazardous_chemicals.*.unit' => 'string',
            'dc_address_under_territorial_limit_where_chemicals_falls' => 'required|string|max:255',
            'insurer_payment_date_to_insurance_company' => 'required|date_format:Y-m-d|after_or_equal:2025-01-01|before_or_equal:today',
            'date_of_declaration' => 'required|date_format:Y-m-d',
            'payment_mode' => 'required|string|in:NEFT,RTGS,UPI,CHEQUE,CASH,DD,CARD',
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
        $insurer_payment_date = $data['insurer_payment_date_to_insurance_company'] ?? null;
        $date_of_declaration = $data['date_of_declaration'] ?? null;

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

        if ($insurer_payment_date && $erfPaymentDate && strtotime($insurer_payment_date) > strtotime($erfPaymentDate)) {
            $validator->errors()->add('insurer_payment_date', 'The Insurer Payment Date must be before the ERF Payment Date.');
        }

        if ($date_of_declaration && strtotime($date_of_declaration) < strtotime($proposalDate)) {
            $validator->errors()->add('erf_payment_date', 'The Date of Declaration must be the same as or after the date of proposal.');
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

    private function detectChemicalChanges($existingChemical, $incomingChemical): array
    {
        $changes = [];

        // Map incomingChemical keys to model properties if needed
        $mapKeys = [
            'id' => 'chemical_stored_lists_id',
            'quantity' => 'quantity',
            'unit' => 'unit',
        ];

        foreach ($mapKeys as $incomingKey => $modelKey) {
            if (isset($incomingChemical[$incomingKey]) && $existingChemical->$modelKey != $incomingChemical[$incomingKey]) {
                $changes[$modelKey] = $incomingChemical[$incomingKey];
            }
        }

        return $changes;
    }

}
