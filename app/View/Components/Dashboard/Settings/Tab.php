<?php

namespace App\View\Components\Dashboard\Settings;

use Illuminate\View\Component;

class Tab extends Component
{
    public $tabs = [];
    public function __construct($tabs)
    {
        $this->tabs = $tabs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.settings.tab');
    }
}
