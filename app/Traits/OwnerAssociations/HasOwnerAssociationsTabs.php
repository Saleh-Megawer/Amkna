<?php
namespace App\Traits\OwnerAssociations;

trait HasOwnerAssociationsTabs
{

    // public $tabs = [
    //     [
    //         'name' => 'المواصفات والخصائص',
    //         'link' => 'main',
    //         'link_type' => 'anchor'
    //     ],
    //     [
    //         'name' => 'السعر',
    //         'link' => 'price',
    //         'link_type' => 'anchor'
    //     ],
    //     [
    //         'name' => 'الصور',
    //         'link' => 'images',
    //         'link_type' => 'anchor'
    //     ],
    //     [
    //         'name' => 'العنوان والوصف',
    //         'link' => 'title-desc',
    //         'link_type' => 'anchor'
    //     ],
    //     [
    //         'name' => 'العنوان والخريطة',
    //         'link' => 'location',
    //         'link_type' => 'anchor'
    //     ],
    //     [
    //         'name' => 'المميزات & الراحة',
    //         'link' => 'features-amenities',
    //         'link_type' => 'anchor'
    //     ],
    //     [
    //         'name' => 'تضمين فيديو',
    //         'link' => 'youtube-video',
    //         'link_type' => 'anchor'
    //     ],
    // ];

    // public $currentTab = '';

    /**
     * Build the links map used in views (breadcrumb / buttons).
     */
    private function linksMap()
    {
        return [
            'index' => [
                'title' => 'اتحادات الملاك',
                'url'   => route('owner-associations.index'),
            ],

            'show'  => [
                'title' => 'ملف اتحاد ملاك',
                'url'   => null,
            ],

            'requests'  => [
                'title' => 'الطلبات & الشكاوي',
                'url'   => null,
            ],
        ];
    }

    /**
     * Initialize current tab from request.
     */
    public function bootTabs()
    {
        //   $this->currentTab = request('tab', 'main');
        view()->share('linksMap', $this->linksMap());

    }

}
