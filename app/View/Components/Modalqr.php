<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modalqr extends Component
{
    public $nik;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($nik)
    {
        $this->nik = $nik;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modalqr');
    }
}
