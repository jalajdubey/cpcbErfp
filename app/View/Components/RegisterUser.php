<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RegisterUser extends Component
{
    /**
     * Create a new component instance.
     */
    public $userRoles;

    public function __construct($userRoles)
    {
        $this->userRoles = $userRoles;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.register-user');
    }
}
