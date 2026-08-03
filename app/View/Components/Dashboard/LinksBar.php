<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class LinksBar extends Component
{
    public $links = [];
    public $buttons = [];


    public function __construct($links = [], $buttons = [])
    {
        $this->links = $links;
        $this->buttons = $buttons;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.links-bar');
    }
}
