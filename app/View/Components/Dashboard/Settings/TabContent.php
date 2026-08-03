<?php

namespace App\View\Components\Dashboard\Settings;

use Illuminate\View\Component;

class TabContent extends Component
{
    public $tab;
    public $name;
    public $class;



    public function __construct($name ,$tab ,$class = null)
    {
        $this->name = $name;
        $this->tab = $tab;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.settings.tab-content');
    }
}
