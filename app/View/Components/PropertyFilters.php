<?php
namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PropertyFilters extends Component
{
    public $propertyTypes;
    public $sections;
    public $showSearchButton;
    public $filterRanges;

    //
    public $filters;

    /**
     * Create a new component instance.
     */
    public function __construct($data = [], $propertyTypes = [], $filterRanges = [], $sections = [], $showSearchButton = false)
    {

        $this->filters = isset($data['filters']) && is_array($data['filters'])? $data['filters']: [];

        $this->propertyTypes    = $propertyTypes;
        $this->sections         = $sections;
        $this->showSearchButton = $showSearchButton;
        $this->filterRanges     = $filterRanges;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.property-filters');
    }
}
