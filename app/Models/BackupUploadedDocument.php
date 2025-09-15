<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupUploadedDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'original_id',
        'user_id',
        'version',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'batch_reference',
        'insured_company_id',
        'policy_number',
    ];
}
