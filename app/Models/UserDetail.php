<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // 👈 add this
        'user_id',// add other fields you want to allow for mass assignment
        'user_role_id',
        'state_id',
        'district_id',
        'locality',
        'pincode',
        'address',
        'mobile',
        'chemical_stored_list_id',
        'pan_no',
        'gst',
        'authorised_person_email',
    ];
}
