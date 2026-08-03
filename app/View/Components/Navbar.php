<?php
namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Navbar Component
 *
 * Options you can pass:
 * - theme: string (e.g. "transparent-bg-with-white-links", "nav-main-theme")
 * - fixed: bool (true => adds "fixed-top")
 * - shadow: bool (true => adds "shadow-lg")
 * - extra: string (custom classes)
 *
 * Example:
 * <x-navbar :options="['theme' => 'transparent', 'fixed' => true, 'shadow' => true]" />
 */
class Navbar extends Component
{
    public $options;

    public function __construct($options = [])
    {

        $defaults = [
            'full_width'  => false, // true = container | false = remove container
            'show'        => true, // Hide And Show Navbar
            'hide_search' => false,
        ];

        // // استبدال القيم
        $options = array_replace($defaults, $options);

        // /**
        //  *
        //  */
        // $options['fixed_top'] = ($options['fixed_top'] == 'absolute') ? 'fixed-top-abs' : $options['fixed_top'];

        $this->options = $options;

    }

    public function render()
    {
        return view('components.navbar');
    }
}
