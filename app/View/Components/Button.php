<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    private $allowedType = ['submit', 'button', 'reset'];


    public $type;
    public $text;
    public $class = null;


    public function __construct($type = 'submit', $text = 'Add Text !', $class = 'btn btn-warning')
    {
        $this->type  = $type;
        $this->text  = $text;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
