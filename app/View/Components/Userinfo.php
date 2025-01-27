<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Userinfo extends Component
{
    public $userinfo;
    /**
     * Create a new component instance.
     */
    public function __construct($userinfo)
    {
        $this->userinfo = $userinfo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.userinfo');
    }
}
