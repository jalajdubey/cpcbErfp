<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyLookupLog extends Model
{
    use HasFactory;
    protected $fillable = [
    'policy_number',
    'requested_ip',
    'status',
    'message',
];
}
