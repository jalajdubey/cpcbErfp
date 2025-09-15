<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'otp_verifications';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id', 'email', 'otp', 'expires_at', 'verified'
    ];

    // Indicates if the model should use timestamps (created_at and updated_at)
    public $timestamps = true;

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Custom method to check if the OTP is valid
    public function isValid()
    {
        return !$this->verified && $this->expires_at > now();
    }
}