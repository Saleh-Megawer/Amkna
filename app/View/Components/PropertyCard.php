<?php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PropertyCard extends Component
{
    public $property;

    /**
     * Create a new component instance.
     */
    public function __construct($property = [])
    {
        $this->property    = $property;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.property-card');
    }
}
