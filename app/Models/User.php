<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $casts = [
        'last_otp_sent_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'mobile_no',
        'email',
        'role_type',
        'password',
        'otp',
        'otp_expires_at',
        'last_otp_sent_at',
        'industry_id',
        'policy_number',
        'industry_name',
        'insured_company_id',
        'company_gst',     // ✅ new
        'pan_no',          // ✅ new
        'activation_token',
        'is_active',
        'industry_address_line1',
        'industry_address_line2',
        'industry_city',
        'industry_state',
        'industry_pincode',
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'activation_token',
    ];

    /**
     * Mutator: Always hash password before saving.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * JWT required methods
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name'  => $this->firstname . ' ' . $this->lastname,
            'role'  => $this->role_type,
        ];
    }

    /**
     * Relationships
     */
    public function industry()
    {
        return $this->belongsTo(IndustryMasterData::class, 'id');
    }

    public function insuredCompany()
    {
        return $this->belongsTo(IndustryMasterData::class, 'insured_company_id');
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(UploadedDocument::class);
    }

    public function industryMasterData()
    {
        return $this->hasOne(IndustryMasterData::class);
    }

    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function validationHash()
    {
        return $this->hasOne(UserValidationHash::class);
    }

    /**
     * Helpers
     */
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role_type, $roles);
        }
        return $this->role_type === $roles;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
