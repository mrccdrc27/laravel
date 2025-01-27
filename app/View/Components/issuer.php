<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class issuer extends Component
{
    public $issuer;
    /**
     * Create a new component instance.
     */
    public function __construct($issuer)
    {
        $this->issuer = $issuer;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.issuer');
    }
}
