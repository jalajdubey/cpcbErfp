<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryChemical extends Model
{
    use HasFactory;

    protected $table = 'industry_chemicals'; // Specify the table name

      protected $fillable = [
        'industry_master_data_id',
        'chemical_stored_lists_id',
        'quantity',
        'unit'
    ];

    // Relationship back to IndustryMasterData
    public function industryMasterData()
    {
        return $this->belongsTo(IndustryMasterData::class, 'industry_master_data_id');
    }
}
