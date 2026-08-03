<?php
namespace App\Traits\Property;

use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Property\PropertyAmenity;
use App\Models\Property\PropertyFeature;
use App\Models\Property\PropertyFinishingType;
use App\Models\Property\PropertyType;

/**
 * Handles shared data, view mappings, and loader utilities for Property module.
 */
trait HandlesPropertyData
{
    public $get = [];

    /**
     * Boot shared data and share links map.
     */
    public function bootSharedData($attr = [])
    {
        //
        $cityId = isset($attr['city_id']) && $attr['city_id'] ? $attr['city_id'] : null;

        $this->get = [
            "propertyTypes"         => PropertyType::select('id')->get(),
            "propertyStatuses"      => collect([]),

            "cities"                => City::select('id')->get(),

            "neighborhoods"         => Neighborhood::when($cityId, fn($q) => $q->where('city_id', $cityId))->select('id')->get(),

            "propertyFinishingType" => PropertyFinishingType::select('id')->get(),
            "features"              => PropertyFeature::select('id')->get(),
            "amenities"             => PropertyAmenity::select('id')->get(),
        ];

    }

    /**
     * Build the links map used in views (breadcrumb / buttons).
     */
    public function linksMap()
    {
        return [
            'index' => [
                'title' => 'الوحدات',
                'url'   => route('properties.index'),
            ],
            // 'create' => [
            //     'title' => 'اضافة وحدة جديدة',
            //     'url'   => route('properties.create'),
            // ],
            'edit'  => [
                'title' => 'تعديل الوحدة',
                'url'   => null,
            ],
        ];
    }

    /**
     * Prepare view data for create/edit pages.
     */
    public function getViewData($attr = [])
    {
        $this->bootSharedData($attr);

        return array_merge($this->get, [
            'tabs'           => $this->tabs,
            'currentTab'     => $this->currentTab,
            'currentTabName' => collect($this->tabs)->firstWhere('link', $this->currentTab)['name'],
        ]);
    }

}
