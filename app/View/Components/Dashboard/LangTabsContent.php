<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class LangTabsContent extends Component
{
    public $langKey = '';
    public $active = false;

    public function __construct($key, $active = false)
    {
        //
        $this->langKey = $key;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.lang-tabs-content');
    }
}
