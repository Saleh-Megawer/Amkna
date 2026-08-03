<?php
namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class InputPrice extends Component
{
    public $options = [];

    public function __construct($options)
    {
    
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.input-price');
    }
}
