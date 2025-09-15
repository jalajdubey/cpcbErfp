<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'batch_reference',
        'insured_company_id',
         'policy_number',
         'user_id'

    ];
}
