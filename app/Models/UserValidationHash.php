<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserValidationHash extends Model
{
    protected $connection = 'security';
    protected $fillable = ['user_id', 'validation_hash'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}