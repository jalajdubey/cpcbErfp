<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;

class SecureFileController extends Controller
{
    //
//    public function download($path)
// {
//     $filePath = 'public/' . $path; // e.g., public/uploads/policy_document/2025/06/filename.pdf

//     if (!Storage::exists($filePath)) {
//         abort(404, 'File not found.');
//     }

//     return Storage::download($filePath);
// }

 public function download($path)
{
    $filePath = 'public/' . $path;

    if (!Storage::exists($filePath)) {
        abort(404, 'File not found.');
    }

    return Storage::response($filePath, null, [
        'Content-Type' => 'application/pdf'
    ]);
}



}
