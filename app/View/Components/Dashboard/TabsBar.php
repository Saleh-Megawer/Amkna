<?php
namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabsBar extends Component
{

    public $tabs;
    public $activeTab;

    public function __construct($tabs = [], $activeTab = 'main')
    {
        $this->tabs      = $tabs;
        $this->activeTab = $activeTab;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.dashboard.tabs-bar');
    }
}
