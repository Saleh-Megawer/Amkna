<?php
namespace App\Traits\Client;

use Illuminate\Support\Optional;

/**
 * Handles shared data, view mappings, and loader utilities for Property module.
 */
trait HandlesClientData
{
    // public $get = [];

    /**
     * Boot shared data and share links map.
     */
    public function bootSharedData()
    {
        // $this->get = [
        //     "propertyTypes"         => PropertyType::select('id')->get(),
        //     "propertyStatuses"      => collect([]),
        //     //
        //     "cities"                => collect([]),
        //     "neighborhoods"         => collect([]),

        //     "propertyFinishingType" => PropertyFinishingType::select('id')->get(),
        //     "features"              => collect([]),
        //     "amenities"             => collect([]),
        // ];

        view()->share('linksMap', $this->linksMap());
    }

    /**
     * Build the links map used in views (breadcrumb / buttons).
     */
    private function linksMap()
    {

        return [
            'index'  => [
                'title' => 'العملاء',
                'url'   => route('crm.clients.index'),
            ],
            'create' => [
                'title' => 'اضافة عميل جديد',
                'url'   => route('crm.clients.create'),
            ],
            'edit'   => [
                'title' => 'عميل',
                'url'   => null,
            ],

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
