<?php
namespace App\Services;

use App\Models\ApiKey;
use App\Models\IndustryMasterData;
use App\Models\UploadedDocument;
use App\Models\BackupUploadedDocument;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DocumentUpdateService
{
    public function handleUpdate(Request $request)
{
    // Step 1: Validate
    $this->validateRequest($request);

    // Step 2: Authenticate
    $tokenRecord = $this->authenticateToken($request->header('x-api-token'));
    if (!$tokenRecord) {
        return response()->json(['message' => 'Invalid API token'], 401);
    }
    $userId = $tokenRecord->user_id;

    // Step 3: Verify industry ownership
    $industry = IndustryMasterData::where([
        'insured_company_id' => $request->insured_company_id,
        'policy_number' => $request->policy_number,
    ])->first();

    if (!$industry) {
        return response()->json([
            'message' => 'Industry data does not match with master records.',
        ], 422);
    }

    // Step 4: Fetch existing document
    $existingDoc = UploadedDocument::where([
        'insured_company_id' => $request->insured_company_id,
        'policy_number' => $request->policy_number,
        'user_id' => $userId
    ])->first();

    if (!$existingDoc) {
        return response()->json([
            'message' => 'Document not found or unauthorized update attempt.',
        ], 403);
    }

    // Step 5: Decode and validate file
    $decoded = $this->decodeBase64($request->file_data);
    if (!$decoded['success']) {
        return response()->json(['message' => $decoded['message']], 422);
    }

    // Step 6: Compare content
    $existingContent = $this->getExistingFileContent($existingDoc->file_path);
    if ($existingContent && $existingContent === $decoded['data']) {
        return response()->json([
            'message' => 'No changes detected. Document content is the same.',
        ], 200);
    }

    // Step 7: Backup and Update
    return $this->backupAndUpdate($existingDoc, $decoded['data'], $request, $userId);
}

   private function validateRequest(Request $request)
{
    Validator::make($request->all(), [
        'file_name' => 'required|string|ends_with:.pdf',
        'file_data' => 'required|string',
        'insured_company_id' => 'required|string',
        'policy_number' => 'required|string',
    ])->validate();
}

            private function authenticateToken($token)
            {
                return ApiKey::where('api_key', $token)->where('active', true)->first();
            }

    private function decodeBase64($base64)
{
    if (Str::contains($base64, ',')) {
        $base64 = explode(',', $base64)[1];
    }

    if (!base64_decode($base64, true)) {
        return ['success' => false, 'message' => 'Invalid base64 format'];
    }

    $decoded = base64_decode($base64);
    if ($decoded === false) {
        return ['success' => false, 'message' => 'Base64 decoding failed'];
    }

    // ✅ Check size limit (2MB = 2 * 1024 * 1024 bytes)
    if (strlen($decoded) > 2097152) {
        return ['success' => false, 'message' => 'File size exceeds 2MB limit'];
    }

    // ✅ PDF signature check
    if (substr($decoded, 0, 4) !== '%PDF') {
        return ['success' => false, 'message' => 'Uploaded content is not a valid PDF file'];
    }

    // ✅ MIME type check
    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($decoded);
    if ($mimeType !== 'application/pdf') {
        return ['success' => false, 'message' => 'File is not a valid PDF based on MIME type'];
    }

    return ['success' => true, 'data' => $decoded];
}


    private function getExistingFileContent($path)
{
    $fullPath = storage_path('app/public/' . $path);
    return file_exists($fullPath) ? file_get_contents($fullPath) : null;
}

 

private function backupAndUpdate($existingDoc, $newContent, Request $request, $userId)
{
    DB::beginTransaction();

    try {
        $sourcePath = $existingDoc->file_path;
        $extension = pathinfo($existingDoc->original_name, PATHINFO_EXTENSION);
        $policyNumber = $request->policy_number;

        $year = now()->format('Y');
        $month = now()->format('m');

        $existingBackups = BackupUploadedDocument::where('original_id', $existingDoc->id)->count();
        $newVersion = $existingBackups + 1;

        $backupDir = "backups/original_policy_document/{$year}/{$month}";
        $backupFileName = "updated-v{$newVersion}-" . now()->format('Ymd') . '.' . $policyNumber . '.' . $extension;
        $backupPath = $backupDir . '/' . $backupFileName;

        // Ensure backup directory exists
        if (!Storage::disk('public')->exists($backupDir)) {
            Storage::disk('public')->makeDirectory($backupDir, 0775, true);
        }

        // Ensure original file exists
        if (!Storage::disk('public')->exists($sourcePath)) {
            throw new \Exception("Original file not found at: storage/app/public/{$sourcePath}");
        }

        // Backup the original
        Storage::disk('public')->copy($sourcePath, $backupPath);
        Storage::disk('public')->delete($sourcePath);

        // Record backup
        BackupUploadedDocument::create([
            'original_id' => $existingDoc->id,
            'user_id' => $userId,
            'version' => $newVersion,
            'original_name' => $existingDoc->original_name,
            'file_path' => $backupPath,
            'mime_type' => $existingDoc->mime_type,
            'file_size' => $existingDoc->file_size,
            'batch_reference' => $existingDoc->batch_reference,
            'insured_company_id' => $existingDoc->insured_company_id,
            'policy_number' => $existingDoc->policy_number,
        ]);

        // Write updated file
        Storage::disk('public')->put($sourcePath, $newContent);

        // Update existing record
        $existingDoc->update([
            'original_name' => $request->file_name,
            'file_size' => strlen($newContent),
            'mime_type' => 'application/pdf',
            'is_updated' => 1,
            'updated_at' => now(),
        ]);

        DB::commit();

        return response()->json([
            'message' => 'Document updated successfully',
            'data' => [
                'id' => $existingDoc->id,
                'file_path' => $existingDoc->file_path,
                'url' => asset('storage/' . $existingDoc->file_path),
                'version' => $newVersion,
            ]
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Document update failed', [
            'user_id' => $userId,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Update failed. Transaction rolled back.',
            'error' => $e->getMessage()
        ], 500);
    }
}



}
