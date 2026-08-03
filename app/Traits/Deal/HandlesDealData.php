<?php
namespace App\Traits\Deal;

use Illuminate\Support\Optional;

/**
 * Handles shared data, view mappings, and loader utilities for Property module.
 */
trait HandlesDealData
{
    // public $get = [];

    /**
     * Boot shared data and share links map.
     */
    public function bootSharedData()
    {
        // $this->get = [
        //     "propertyTypes"         => PropertyType::select('id')->get(),
        // ];

        view()->share('linksMap', json_decode(json_encode($this->linksMap())));
    }

    /**
     * Build the links map used in views (breadcrumb / buttons).
     */
    private function linksMap()
    {
        return [
            'index'          => [
                'page_title' => 'الصفقات',
                'route'      => route('crm.deals.index'),
            ],
            'all_follow_ups' => [
                'page_title' => 'جميع المتابعات',
                'route'      => null,
            ],
            // 'edit'  => [
            //     'page_title' => 'معلومات العميل',
            // ], 'page_title' => isSalesAdmin() ? 'صفقاتي' : 'الصفقات',
        ];

    }

    /**
     * Prepare view data for create/edit pages.
     */
    public function getViewData()
    {
        //'currentTabName' => optional(collect($this->tabs)->firstWhere('link', $this->currentTab))['name'],
        return array_merge([
            'tabs'           => $this->tabs,
            'currentTab'     => $this->currentTab,
            'currentTabName' => collect($this->tabs)->firstWhere('link', $this->currentTab)['name'],
        ]);
    }

}
