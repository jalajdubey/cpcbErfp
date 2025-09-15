<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you're using the User model
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class Monitering extends Controller
{
    //

    public function index()
    {
        
        // Fetch some data you want to show on dashboard, for example, the number of users
        
      
         // Ensure users are passed to the dashboard view
         return view('monitoring.dashboard');
       
    }
}
