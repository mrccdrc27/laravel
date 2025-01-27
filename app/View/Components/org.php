<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class org extends Component
{
    public $org;
    /**
     * Create a new component instance.
     */
    public function __construct($org)
    {
        $this->org = $org;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.org');
    }
}
