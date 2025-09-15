<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;

class UserRole
{
    /**
     * Get all user roles from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUserRoles()
    {
        return Role::all(); // Using Role model to fetch data
    }
}
