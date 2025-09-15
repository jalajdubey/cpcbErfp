<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'ip_address',
        'status',
        'user_id',
        'attempted_at',
    ];

    public $timestamps = true;
}
