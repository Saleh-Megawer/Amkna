<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class Aside extends Component
{

    public $details;

    public $can = []; // Can => Check If can this auth have permission
    /*
    // Example
    /*
            Single =  [
                'name' => 'الرئيسية',
                'icon' => '<i class="fa-solid fa-gauge-high"></i>',
                'link' => 'home'
            ];
            --------------------------
            Multble =  [
                'name' => 'المكتبة',
                'icon' => '<i class="fa-solid fa-photo-film"></i>',
                'can'  => ['role name','role name 2'],
                'sub_menu' => [
                    [
                        'name' => 'الصور',
                        'link' => 'library',
                        'can'  => [ if need to can only one link ],
                    ],
                    [
                        'name' => 'اضافة جديد',
                        'link' => 'library/add-images',
                    ],
                ],
            ];
     */
    public function __construct($details)
    {
        $this->details = $details;

        $this->can = config('dashboard.roles'); // Set All Roles If Not Exist Attr Can In Parents Link
        if (isset($details['can'])) { // IF Isset Can Attr will set
            $this->can = $details['can'];
        }


    }

    public function render()
    {
        return view('components.dashboard.aside');
    }
}
