<?php
namespace App\Traits\Deal;

trait HasDealTabs
{
 
    public $tabs = [
        [
            'name' => 'معلومات الصفقة',
            'link' => 'main',
        ],
        [
            'name' => 'المحادثات',
            'link' => 'chats',
        ],
        [
            'name' => 'المرفقات',
            'link' => 'attachments',
        ],
        [
            'name' => 'المتابعة',
            'link' => 'follow-up',
        ],
    ];

    public $currentTab     = 'main';
    public $currentTabName = 'معلومات الصفقة';

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
