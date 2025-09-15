<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
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
        'is_updated',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function industryPolicy()
    {
        return $this->belongsTo(IndustryMasterData::class, 'policy_number', 'policy_number');
    }
}
