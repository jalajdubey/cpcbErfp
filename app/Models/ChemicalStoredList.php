<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicalStoredList extends Model
{
    use HasFactory;

    protected $table = 'chemical_stored_lists'; // explicitly define table name

    protected $fillable = [
        'part',
        'sr_no',
        'chemical_name',
        'threshold_qty',
        'cas_number',
        'group', // rename if necessary
    ];
}
