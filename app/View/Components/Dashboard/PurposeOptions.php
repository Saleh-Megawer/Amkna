<?php
namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PurposeOptions extends Component
{

    public $only;
    public $selected;

    public function __construct($only = [], $selected = null)
    {
        $this->only     = $only ? (array) $only : [];
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        $purposes = config('project.purpose');

        if (! empty($this->only)) {
            $purposes = collect($purposes)
                ->only($this->only)
                ->toArray();
        }

        return view('components.dashboard.purpose-options', compact('purposes'));
    }
}
