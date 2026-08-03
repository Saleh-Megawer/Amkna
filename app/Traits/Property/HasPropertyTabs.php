<?php
namespace App\Traits\Property;

trait HasPropertyTabs
{

    public $tabs = [
        [
            'name'      => 'المواصفات والخصائص',
            'link'      => 'main',
            'link_type' => 'anchor',
        ],
        [
            'name'      => 'السعر',
            'link'      => 'price',
            'link_type' => 'anchor',
        ],
        [
            'name'      => 'الصور',
            'link'      => 'images',
            'link_type' => 'anchor',
        ],
        [
            'name'      => 'العنوان والوصف',
            'link'      => 'title-desc',
            'link_type' => 'anchor',
        ],
        [
            'name'      => 'العنوان والخريطة',
            'link'      => 'location',
            'link_type' => 'anchor',
        ],
        [
            'name'      => 'المميزات & الراحة',
            'link'      => 'features-amenities',
            'link_type' => 'anchor',
        ],
        [
            'name'      => 'تضمين فيديو',
            'link'      => 'youtube-video',
            'link_type' => 'anchor',
        ],
        // [
        //     'name'      => 'النماذج',
        //     'link'      => 'units',
        //     'link_type' => 'link',
        // ],
    ];

    public $currentTab = '';

    /**
     * Initialize current tab from request.
     */
    public function bootTabs()
    {
        $this->currentTab = request('tab', 'main');
        view()->share('linksMap', $this->linksMap());

    }
}
