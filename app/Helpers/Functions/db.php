<?php

use App\Http\Controllers\Main\PropertyFilterController;
use App\Models\City;
use App\Models\Dashboard\Admin\Admin;
use App\Models\Neighborhood;
use App\Models\Property\PropertyFacade;
use App\Models\Property\PropertyFinishingType;
use App\Models\Property\PropertyType;
use Illuminate\Support\Facades\DB;

if (! function_exists('setting')) {

    function setting(string $key, $default = null)
    {
        return data_get(config('settings'), $key, $default);
    }

}

/**
 * Get Webstie Icon
 */
function website_icon()
{
    return asset('assets/images/favicon.png');
    //return largeAsset('settings/' . DB::table('settings')->first(['website_icon'])?->website_icon);
}

/**
 * Get Webstie Logo
 */
function website_logo(): string
{
    return setting('logo')
        ? largeAsset('settings/' . setting('logo'))
        : asset('images/default-website-logo.png');
}

function footer_logo()
{
    return setting('footer_logo')
        ? largeAsset('settings/' . setting('logo'))
        : asset('images/default-website-logo.png');
}

/////////////////////////////////////// For DB
if (! function_exists('getTags')) {
    function getTags(array $arg = [])
    {
        $q = DB::table('tags')->orderByDesc('id');

        // Type
        if (isset($arg['type'])) {
            $q->where('type', $arg['type']);
        }

        return $q->get();
    }
}

if (! function_exists('getCities')) {
    function getCities()
    {
        return City::select('id')->get();
    }
}

if (! function_exists('getNeighborhoods')) {
    function getNeighborhoods()
    {
        return Neighborhood::select('id')->get();
    }
}

if (! function_exists('getPropertyTypes')) {
    function getPropertyTypes()
    {
        $q = PropertyType::get();
        return $q;
    }
}

if (! function_exists('getPropertyFacade')) {
    function getPropertyFacade()
    {
        $q = PropertyFacade::get();
        return $q;
    }
}

if (! function_exists('getPropertyFinishingType')) {
    function getPropertyFinishingType()
    {
        $q = PropertyFinishingType::get();
        return $q;
    }
}

if (! function_exists('getActiveAvailableSalesAdmins')) {
    function getActiveAvailableSalesAdmins()
    {
        return Admin::typeSales()->isActive()->isAvailable()->select('id', 'full_name', 'email')->get();
    }
}

/******
 *
 *  For Property
 * ****
 */
if (! function_exists('getPropertyFilterRanges')) {
    function getPropertyFilterRanges()
    {
        return PropertyFilterController::getFilterRanges();
    }
}
if (! function_exists('getPropertyTypes')) {
    function getPropertyTypes()
    {
        return PropertyFilterController::getPropertyTypes();
    }
}
if (! function_exists('getPropertyFilterSections')) {
    function getPropertyFilterSections()
    {
        return PropertyFilterController::getFilterSections();
    }
}

if (! function_exists('getNeighborhoodsByCity')) {
    function getNeighborhoodsByCity($cityId)
    {
        $neighborhoods = Neighborhood::where('city_id', $cityId)->select('id')->get();
        return $neighborhoods;
    }
}
