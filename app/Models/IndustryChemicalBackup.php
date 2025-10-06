<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryChemicalBackup extends Model
{
    use HasFactory;

     protected $fillable = [
        'industry_chemicals_id',
        'industry_master_data_backups_id',
        'industry_master_data_id',
        'chemical_stored_lists_id',
        'quantity',
        'unit'
    ];
}
