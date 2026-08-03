<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Paginate extends Component
{
    public $paginator = [];
    public function __construct($data)
    {
        $this->paginator = $data;
    }

    public function render()
    {
        return view('components.paginate');
    }
}
