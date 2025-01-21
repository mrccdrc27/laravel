<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cert extends Component
{
    public $cert;
    /**
     * Create a new component instance.
     */
    public function __construct($cert)
    {
        $this->cert = $cert;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cert');
    }
}
