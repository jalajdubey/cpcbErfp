<?php

namespace App\Services;

use App\Models\State;
use App\Models\Cities;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;

class LocationService
{
    public function getAllStates()
    {
        return State::select('state_id', 'state_name')->get();
    }

    public function getDistrictsByStateId($stateId)
    {
        return Cities::where('state_id', $stateId)->select('id', 'name')->get();
    }
}
