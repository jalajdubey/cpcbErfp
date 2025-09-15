<?php
namespace App\Services;

use App\Models\ApiKey;
use App\Models\IndustryMasterData;
use App\Models\UploadedDocument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

class DocumentUploadService
{
 public function handleUpload($request)
    {
        try {
            $this->validateRequest($request);

            $tokenRecord = $this->authenticate($request->header('X-API-TOKEN'));
            if (!$tokenRecord) {
                return response()->json(['message' => 'Invalid or inactive API token.'], 401);
            }

            $userId = $tokenRecord->user_id;
            $batchReferenceId = 'BATCH-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(5));
            $decodedFiles = [];

            DB::beginTransaction();

            foreach ($request->documents as $index => $doc) {
                $result = $this->validateAndPrepareDocument($doc, $userId, $batchReferenceId, $index);

                if (isset($result['error'])) {
                    DB::rollBack();

                    Log::warning('Upload failed due to validation error', [
                        'batch_reference' => $batchReferenceId,
                        'document_index' => $index,
                        'file_name' => $doc['file_name'] ?? 'Unknown',
                        'errors' => $result['error']['errors']
                    ]);

                    return $this->responseWithErrors([$result['error']], $batchReferenceId);
                }

                $decodedFiles[] = $result['data'];
            }

            $saved = $this->storeDocuments($decodedFiles);
            DB::commit();

            return $this->successResponse($saved, $batchReferenceId);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return $this->handleException($e, 'UNKNOWN');
        }
    }

    private function validateRequest($request)
    {
        $request->validate([
            'documents' => 'required|array|max:10',
        ]);
    }

    private function authenticate($token)
    {
        return ApiKey::where('api_key', $token)->where('active', true)->first();
    }

    private function validateAndPrepareDocument($doc, $userId, $batchReferenceId, $index)
    {
        $validator = Validator::make($doc, [
            'file_name' => 'required|string|ends_with:.pdf',
            'file_data' => 'required|string',
           // 'insured_company_id' => 'required|string',
            'policy_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ['error' => $this->errorPayload($index, $doc['file_name'], $validator->errors()->all())];
        }

        // $industryRecord = IndustryMasterData::where('insured_company_id', $doc['insured_company_id'])
        //     ->where('policy_number', $doc['policy_number'])->first();
        $industryRecord = IndustryMasterData::where('policy_number', $doc['policy_number'])->first();

        // if (!$industryRecord || $industryRecord->user_id !== $userId) {
        //     $reason = !$industryRecord ? 'Insured company/policy mismatch' : 'User ID mismatch';
        //     return ['error' => $this->errorPayload($index, $doc['file_name'], [$reason])];
        // }

        if (!$industryRecord || $industryRecord->user_id !== $userId) {
    $reason = !$industryRecord ? 'Policy number not found' : 'User ID mismatch';
    return ['error' => $this->errorPayload($index, $doc['file_name'], [$reason])];
}

        $base64 = Str::contains($doc['file_data'], ',') ? explode(',', $doc['file_data'])[1] : $doc['file_data'];
        $base64 = str_replace(["\r", "\n"], '', $base64);

        if (!preg_match('/^[a-zA-Z0-9\/+]+={0,2}$/', $base64)) {
            return ['error' => $this->errorPayload($index, $doc['file_name'], ['Invalid base64 encoding'])];
        }

        $decoded = base64_decode($base64, true);
        if ($decoded === false) {
            return ['error' => $this->errorPayload($index, $doc['file_name'], ['Base64 decoding failed'])];
        }

        if (strlen($decoded) > 2 * 1024 * 1024) {
            return ['error' => $this->errorPayload($index, $doc['file_name'], ['PDF file size exceeds 2MB'])];
        }

        // ✅ Check for %PDF and %%EOF markers
        if (strncmp($decoded, '%PDF', 4) !== 0 || !str_contains($decoded, '%%EOF')) {
            return ['error' => $this->errorPayload($index, $doc['file_name'], ['Corrupt or incomplete PDF content'])];
        }

        // ✅ Try parsing using smalot/pdfparser
        try {
            $parser = new Parser();
            $pdf = $parser->parseContent($decoded);

            if (empty($pdf->getPages())) {
                return ['error' => $this->errorPayload($index, $doc['file_name'], ['Unreadable PDF (no pages found)'])];
            }
        } catch (\Exception $e) {
            return ['error' => $this->errorPayload($index, $doc['file_name'], ['Unreadable or corrupt PDF: ' . $e->getMessage()])];
        }

        $year = now()->format('Y');
        $month = now()->format('m');
        $folder = "uploads/policy_document/{$year}/{$month}/";
        $fileName = $doc['policy_number'] . '.pdf';
        $filePath = $folder . $fileName;

        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        if (
            Storage::disk('public')->exists($filePath) ||
            UploadedDocument::where([
                'user_id' => $userId,
                // 'insured_company_id' => $doc['insured_company_id'],
                'policy_number' => $doc['policy_number'],
                'file_path' => $filePath
            ])->exists()
        ) {
            return ['error' => $this->errorPayload($index, $doc['file_name'], ['Duplicate file or record'])];
        }

        return ['data' => [
    'path' => $filePath,
    'content' => $decoded,
    'meta' => [
        'user_id' => $userId,
        'original_name' => $fileName,
        'mime_type' => 'application/pdf',
        'file_size' => strlen($decoded),
        'batch_reference' => $batchReferenceId,
        'policy_number' => $doc['policy_number'],
        ...(isset($doc['insured_company_id']) ? ['insured_company_id' => $doc['insured_company_id']] : []),
    ]
        ]];
    }

    private function storeDocuments($files)
{
    $saved = [];

    foreach ($files as $file) {
        Storage::disk('public')->put($file['path'], $file['content']);

        $record = UploadedDocument::create([
            'user_id' => $file['meta']['user_id'],
            'original_name' => $file['meta']['original_name'],
            'file_path' => $file['path'],
            'mime_type' => $file['meta']['mime_type'],
            'file_size' => $file['meta']['file_size'],
            'batch_reference' => $file['meta']['batch_reference'],
            'insured_company_id' => $file['meta']['insured_company_id'] ?? null, // <- ✅ this line updated
            'policy_number' => $file['meta']['policy_number'],
        ]);

        $saved[] = [
            'id' => $record->id,
            'original_name' => $record->original_name,
            'file_path' => $record->file_path,
            'batch_reference' => $record->batch_reference,
            'insured_company_id' => $record->insured_company_id,
            'policy_number' => $record->policy_number,
            'url' => asset('storage/' . $record->file_path),
        ];
    }

    return $saved;
}

    private function errorPayload($index, $fileName, $errors)
    {
        return [
            'index' => $index,
            'file_name' => $fileName,
            'errors' => $errors,
        ];
    }

    private function responseWithErrors($errors, $batchReferenceId)
    {
        return response()->json([
            'message' => 'Upload aborted. Errors found in one or more documents.',
            'failed_uploads' => $errors,
            'batch_reference' => $batchReferenceId,
        ], 422);
    }

    private function successResponse($saved, $batchReferenceId)
    {
        return response()->json([
            'message' => 'All documents uploaded successfully.',
            'batch_reference' => $batchReferenceId,
            'successful_uploads' => $saved,
        ], 201);
    }

    private function handleException($e, $batchReferenceId)
    {
        Log::error('Upload failed due to exception', [
            'batch_reference' => $batchReferenceId,
            'exception_class' => get_class($e),
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'message' => 'Internal server error. Upload failed.',
            'error' => $e->getMessage(),
            'batch_reference' => $batchReferenceId,
        ], 500);
    }
}

