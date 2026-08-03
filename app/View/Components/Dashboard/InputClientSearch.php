<?php
namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class InputClientSearch extends Component
{
    public string $label;
    public string $name;
    public bool $required;
    public  $valueText;
    public  $valueId;

    public function __construct(
        string $label = 'العميل',
        string $name = 'client_id',
        bool $required = true,
        $valueText = null,
        $valueId = null
    ) {
        $this->label     = $label;
        $this->name      = $name;
        $this->required  = $required;
        $this->valueText = $valueText;
        $this->valueId   = $valueId;
    }

    public function render()
    {
        return view('components.dashboard.input-client-search');
    }
}
