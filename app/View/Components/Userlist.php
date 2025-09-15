<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Userlist extends Component
{
   

    public $users;

    // Constructor to accept users data
    public function __construct($users)
    {
        $this->users = $users;
    }

    public function render()
    {
        return view('components.userlist');
    }
}
