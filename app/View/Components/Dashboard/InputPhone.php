<?php
namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class InputPhone extends Component
{
    public $phone;
    public $code;
    public $options = [];

    public function __construct($phone = null, $code = null, $options = [])
    {
        $this->phone   = $phone;
        $this->code    = $code;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.input-phone');
    }
}
