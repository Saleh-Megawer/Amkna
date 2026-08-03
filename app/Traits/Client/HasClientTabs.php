<?php
namespace App\Traits\Client;

trait HasClientTabs
{
    public $tabs = [
        [
            'name' => 'المعلومات الشخصية',
            'link' => 'main',
        ],
        [
            'name' => 'الصفقات ذات الصلة',
            'link' => 'deals',
        ],
        [
            'name' => 'الملاحظات',
            'link' => 'notes',
        ],
        [
            'name' => 'سجل التعديلات',
            'link' => 'logs',
        ],
    ];

    public $currentTab     = 'main';
    public $currentTabName = 'المعلومات الشخصية';

    /**
     * Initialize current tab from request.
     */
    public function bootTabs()
    {
        $validTabs = collect($this->tabs)->pluck('link')->toArray();

        $requested = request('tab', 'main');

        $this->currentTab = in_array($requested, $validTabs) ? $requested : 'main';

        $this->currentTabName = collect($this->tabs)->firstWhere('link', $this->currentTab)['name'];
    }
}
