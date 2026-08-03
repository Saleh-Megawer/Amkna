<?php
namespace App\Http\Controllers\Main;

use App\Helpers\PhoneNormalizer;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\PropertyFilterController;
use App\Models\City;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Source;
use App\Models\Interest;
use App\Models\Neighborhood;
use App\Models\Property\Property;
use App\Services\PropertyListingSeo\PropertyListingTitleBuilder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{

    public function svg_icons()
    {
        return [

            'info'       => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>',
            'floor_icon' =>
            '<svg fill="#000000" height="16px" width="16px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M490.667,170.667H416V21.333h74.667c5.867,0,10.667-4.8,10.667-10.667C501.333,4.8,496.533,0,490.667,0h-85.333 c-0.32,0-0.64,0.107-0.96,0.213c-0.64,0.107-1.28,0.213-1.92,0.427c-1.067,0.32-2.133,0.853-3.093,1.493h-0.107 c-0.533,0.32-1.067,0.747-1.6,1.173l-84.16,63.147c-0.427,0.213-0.747,0.533-1.173,0.853l-84.48,63.36 c-0.213,0.213-0.533,0.32-0.747,0.64l-84.907,63.68c-0.107,0.107-0.32,0.213-0.427,0.32L56.427,259.2l-41.493,31.04 c-4.693,3.52-5.653,10.24-2.133,14.933c3.52,4.693,10.24,5.653,14.933,2.133l25.6-19.2v138.56h-32 c-5.867,0-10.667,4.8-10.667,10.667v64c0,5.867,4.8,10.667,10.667,10.667h469.333c5.867,0,10.667-4.8,10.667-10.667v-320 C501.333,175.467,496.533,170.667,490.667,170.667z M330.667,80.213l64-48v138.453H384c-5.867,0-10.667,4.8-10.667,10.667v53.333 h-42.667V80.213z M245.333,144.213l64-48v138.453h-10.667c-5.867,0-10.667,4.8-10.667,10.667V288h-42.667V144.213z M160,208.107 l64-48V288h-21.333C196.8,288,192,292.8,192,298.667v64h-32V208.107z M74.667,272.107l64-48v138.56h-21.333 c-5.867,0-10.667,4.8-10.667,10.667v53.333h-32V272.107z M480,490.667H32V448h85.333C123.2,448,128,443.2,128,437.333V384h74.667 c5.867,0,10.667-4.8,10.667-10.667v-64h85.333c5.867,0,10.667-4.8,10.667-10.667V256H384c5.867,0,10.667-4.8,10.667-10.667V192 H480V490.667z"></path> </g> </g> </g></svg>',
            //
            'bathrooms'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="#000000" viewBox="0 0 256 256"><path d="M64,236a12,12,0,1,1-12-12A12,12,0,0,1,64,236Zm20-44a12,12,0,1,0,12,12A12,12,0,0,0,84,192Zm-64,0a12,12,0,1,0,12,12A12,12,0,0,0,20,192Zm32-32a12,12,0,1,0,12,12A12,12,0,0,0,52,160ZM256,40a8,8,0,0,1-8,8H219.31L191.46,75.86,169.8,202.65a16,16,0,0,1-27.09,8.66l-98-98a16,16,0,0,1,8.69-27.1L180.14,64.54l30.2-30.2A8,8,0,0,1,216,32h32A8,8,0,0,1,256,40ZM174.21,81.79,56,102l98,98Z"></path></svg>',
            //
            'bedrooms'   => '<svg fill="#000000" width="16px" height="16px" viewBox="0 -11.47 122.88 122.88" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="enable-background:new 0 0 122.88 99.94" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M4.22,67.36h114.31v-4.67c0-1.13-0.22-2.18-0.61-3.12c-0.42-1-1.04-1.89-1.81-2.66c-0.47-0.47-1-0.9-1.57-1.28 c-0.58-0.39-1.2-0.73-1.85-1.02c-1.75-0.38-3.49-0.74-5.22-1.08c-1.74-0.34-3.49-0.66-5.25-0.96c-0.08-0.01-0.14-0.02-0.22-0.04 c-0.89-0.15-1.74-0.29-2.55-0.42c-0.81-0.13-1.67-0.26-2.57-0.4l-0.02,0c-6.12-0.78-12.22-1.38-18.31-1.78 c-6.1-0.4-12.17-0.6-18.2-0.61c-3.58,0-7.15,0.06-10.72,0.2c-3.55,0.14-7.12,0.34-10.69,0.62l-0.02,0 c-3.34,0.31-6.67,0.7-10.01,1.15c-3.33,0.45-6.67,0.98-10.03,1.57l-0.37,0.09c-0.07,0.02-0.14,0.03-0.2,0.03 c-0.06,0.01-0.12,0.01-0.18,0.01c-1.57,0.28-3.18,0.59-4.84,0.92c-1.61,0.32-3.22,0.66-4.82,1.01c-0.4,0.22-0.78,0.47-1.14,0.73 c-0.36,0.27-0.71,0.56-1.02,0.87v0c-0.67,0.67-1.2,1.44-1.56,2.3c-0.34,0.81-0.53,1.71-0.53,2.69V67.36L4.22,67.36z M14.2,0h92.99 c1.21,0,2.37,0.24,3.43,0.68c1.1,0.46,2.09,1.13,2.92,1.95c0.83,0.83,1.5,1.82,1.95,2.92c0.44,1.06,0.68,2.22,0.68,3.43v42.69 c0.51,0.3,1.01,0.63,1.47,0.99c0.52,0.4,1.01,0.82,1.46,1.27c1.16,1.16,2.1,2.51,2.73,4.03c0.6,1.43,0.93,3.02,0.93,4.74v6.09 c0.03,0.1,0.06,0.2,0.08,0.3l0,0.02c0.02,0.13,0.03,0.25,0.03,0.37c0,0.13-0.01,0.26-0.04,0.39l0,0c-0.02,0.1-0.05,0.2-0.08,0.3 v27.66c0,0.58-0.24,1.11-0.62,1.49c-0.38,0.38-0.91,0.62-1.49,0.62h-4.35c-0.49,0-0.94-0.17-1.3-0.45 c-0.36-0.28-0.63-0.68-0.74-1.14c-0.8-2.3-1.61-4.12-2.48-5.54c-0.86-1.4-1.78-2.4-2.84-3.11c-1.07-0.71-2.35-1.16-3.9-1.43 c-1.58-0.28-3.42-0.37-5.61-0.36l-79.76,0.1l-0.04,0c-1.57-0.03-2.86,0.17-3.94,0.59c-1.07,0.42-1.94,1.05-2.66,1.86 c-0.81,0.9-1.49,2.05-2.11,3.39c-0.63,1.37-1.2,2.93-1.77,4.64l0,0c-0.14,0.44-0.42,0.79-0.77,1.04c-0.33,0.24-0.73,0.38-1.14,0.4 c-0.03,0.01-0.06,0.01-0.09,0.01H2.11c-0.58,0-1.11-0.24-1.49-0.62C0.24,98.94,0,98.41,0,97.83V61.52c0-1.57,0.3-3.01,0.84-4.31 c0.58-1.38,1.43-2.61,2.49-3.67c0.3-0.3,0.63-0.6,0.98-0.88c0.3-0.24,0.6-0.47,0.92-0.68V8.89c0-1.21,0.24-2.36,0.68-3.4 c0.46-1.09,1.13-2.07,1.96-2.89c0.83-0.82,1.82-1.47,2.91-1.92C11.84,0.24,12.99,0,14.2,0L14.2,0z M107.19,4.22H14.2 c-0.65,0-1.27,0.13-1.84,0.36c-0.59,0.24-1.11,0.59-1.55,1.02c-0.43,0.42-0.78,0.94-1.02,1.5C9.57,7.65,9.45,8.25,9.45,8.89v41.06 c0.3-0.1,0.6-0.18,0.91-0.26c0.49-0.13,0.98-0.24,1.47-0.32c0.68-0.12,1.42-0.25,2.22-0.39c0.6-0.1,1.24-0.21,1.9-0.31V38.19 c0-1.58,0.32-3.09,0.89-4.47c0.6-1.44,1.47-2.73,2.55-3.81c1.08-1.08,2.37-1.95,3.81-2.55c1.38-0.57,2.89-0.89,4.47-0.89h19.82 c1.58,0,3.09,0.32,4.47,0.89c1.44,0.6,2.73,1.47,3.81,2.55c1.08,1.08,1.95,2.37,2.55,3.81c0.57,1.38,0.89,2.89,0.89,4.47v6.69 c0.7-0.01,1.4-0.01,2.11-0.01v-6.68c0-1.58,0.32-3.09,0.89-4.47c0.6-1.44,1.47-2.73,2.55-3.81c1.08-1.08,2.37-1.95,3.81-2.55 c1.38-0.57,2.89-0.89,4.47-0.89h19.82c1.58,0,3.09,0.32,4.47,0.89c1.44,0.6,2.73,1.47,3.81,2.55c1.08,1.08,1.95,2.37,2.55,3.81 c0.57,1.38,0.89,2.89,0.89,4.47v10.34c0.75,0.11,1.55,0.24,2.41,0.38c0.95,0.15,1.86,0.3,2.74,0.45c0.45,0.08,0.91,0.17,1.37,0.28 c0.29,0.07,0.57,0.14,0.84,0.22V8.98c0-0.64-0.13-1.25-0.36-1.81c-0.24-0.58-0.6-1.1-1.04-1.55c-0.44-0.44-0.97-0.8-1.54-1.04 C108.44,4.35,107.83,4.22,107.19,4.22L107.19,4.22z M43.21,45.56c2.01-0.15,4.03-0.28,6.08-0.38c1.89-0.1,3.8-0.17,5.71-0.22v-6.77 c0-1.01-0.2-1.98-0.57-2.86c-0.38-0.92-0.94-1.74-1.64-2.44c-0.69-0.69-1.52-1.25-2.44-1.64c-0.88-0.37-1.85-0.57-2.86-0.57H27.67 c-1.01,0-1.98,0.2-2.86,0.57c-0.92,0.38-1.74,0.94-2.44,1.64c-0.69,0.69-1.25,1.52-1.64,2.44c-0.37,0.88-0.57,1.85-0.57,2.86V48 c1.62-0.24,3.26-0.46,4.94-0.68c1.81-0.23,3.61-0.44,5.39-0.64c0.69-0.08,1.43-0.17,2.2-0.25c0.72-0.08,1.47-0.15,2.27-0.23 c1.36-0.13,2.71-0.25,4.04-0.36C40.37,45.75,41.77,45.65,43.21,45.56L43.21,45.56z M65.54,44.9c1.21,0.02,2.42,0.05,3.63,0.09 c1.34,0.04,2.68,0.1,4.01,0.16l0.01,0c2.19,0.08,4.33,0.18,6.41,0.3c2.08,0.12,4.11,0.27,6.05,0.44c2.82,0.25,5.55,0.55,8.14,0.9 c2.32,0.32,4.52,0.68,6.58,1.08v-9.68c0-1.01-0.2-1.98-0.57-2.86c-0.38-0.92-0.94-1.74-1.64-2.44c-0.69-0.69-1.52-1.25-2.44-1.64 c-0.88-0.37-1.85-0.57-2.86-0.57H73.05c-1.01,0-1.98,0.2-2.86,0.57c-0.92,0.38-1.74,0.94-2.44,1.64c-0.69,0.69-1.25,1.52-1.64,2.44 c-0.37,0.88-0.57,1.85-0.57,2.86V44.9L65.54,44.9z M118.54,71.59H4.22v24.13h1.43c0.56-1.58,1.14-3.05,1.79-4.36 c0.7-1.4,1.49-2.64,2.45-3.71c1.14-1.28,2.48-2.27,4.09-2.93c1.61-0.65,3.49-0.98,5.75-0.93l79.69-0.1c2.57,0,4.77,0.12,6.69,0.49 c1.95,0.37,3.63,1,5.14,2c1.4,0.93,2.6,2.16,3.68,3.77c1.03,1.54,1.95,3.43,2.83,5.76h0.76V71.59L118.54,71.59z"></path> </g> </g></svg>',
            //
            'front'      => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216ZM172.42,72.84l-64,32a8.05,8.05,0,0,0-3.58,3.58l-32,64A8,8,0,0,0,80,184a8.1,8.1,0,0,0,3.58-.84l64-32a8.05,8.05,0,0,0,3.58-3.58l32-64a8,8,0,0,0-10.74-10.74ZM138,138,97.89,158.11,118,118l40.15-20.07Z"></path></svg>',

            'faq'        => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M140,180a12,12,0,1,1-12-12A12,12,0,0,1,140,180ZM128,72c-22.06,0-40,16.15-40,36v4a8,8,0,0,0,16,0v-4c0-11,10.77-20,24-20s24,9,24,20-10.77,20-24,20a8,8,0,0,0-8,8v8a8,8,0,0,0,16,0v-.72c18.24-3.35,32-17.9,32-35.28C168,88.15,150.06,72,128,72Zm104,56A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path></svg>',

            'status'     => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M254.3,107.91,228.78,56.85a16,16,0,0,0-21.47-7.15L182.44,62.13,130.05,48.27a8.14,8.14,0,0,0-4.1,0L73.56,62.13,48.69,49.7a16,16,0,0,0-21.47,7.15L1.7,107.9a16,16,0,0,0,7.15,21.47l27,13.51,55.49,39.63a8.06,8.06,0,0,0,2.71,1.25l64,16a8,8,0,0,0,7.6-2.1l55.07-55.08,26.42-13.21a16,16,0,0,0,7.15-21.46Zm-54.89,33.37L165,113.72a8,8,0,0,0-10.68.61C136.51,132.27,116.66,130,104,122L147.24,80h31.81l27.21,54.41ZM41.53,64,62,74.22,36.43,125.27,16,115.06Zm116,119.13L99.42,168.61l-49.2-35.14,28-56L128,64.28l9.8,2.59-45,43.68-.08.09a16,16,0,0,0,2.72,24.81c20.56,13.13,45.37,11,64.91-5L188,152.66Zm62-57.87-25.52-51L214.47,64,240,115.06Zm-87.75,92.67a8,8,0,0,1-7.75,6.06,8.13,8.13,0,0,1-1.95-.24L80.41,213.33a7.89,7.89,0,0,1-2.71-1.25L51.35,193.26a8,8,0,0,1,9.3-13l25.11,17.94L126,208.24A8,8,0,0,1,131.82,217.94Z"></path></svg>',

            'furnishing' => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M216,24H72A40,40,0,0,0,32,64v72a24,24,0,0,0,24,24h48l-7.89,46.67A8.42,8.42,0,0,0,96,208a32,32,0,0,0,64,0,8.42,8.42,0,0,0-.11-1.33L152,160h48a24,24,0,0,0,24-24V32A8,8,0,0,0,216,24ZM72,40H176V80a8,8,0,0,0,16,0V40h16v64H48V64A24,24,0,0,1,72,40ZM200,144H152a16,16,0,0,0-15.84,18.26l0,.2L144,208.6a16,16,0,0,1-32,0l7.8-46.14,0-.2A16,16,0,0,0,104,144H56a8,8,0,0,1-8-8V120H208v16A8,8,0,0,1,200,144Z"></path></svg>',
        ];
    }

    public function index(Request $request, PropertyListingTitleBuilder $titleBuilder)
    {
        $filterRanges   = PropertyFilterController::getFilterRanges();
        $propertyTypes  = PropertyFilterController::getPropertyTypes();
        $filterSections = PropertyFilterController::getFilterSections();

        $seo = $titleBuilder->forRequest($request)->build();

        // ✅ Get location name for display
        $locationName = null;

        if ($request->filled('city_id')) {
            $city         = City::find($request->city_id);
            $locationName = $city ? $city->name : null;
        }

        if ($request->filled('neighborhood_id')) {
            $neighborhood = Neighborhood::find($request->neighborhood_id);
            $locationName = $neighborhood ? $neighborhood->name : null;
        }

        // ✅ استخدم الـ method المشتركة
        $query      = PropertyFilterController::buildPropertyQuery($request);
        $properties = $query->paginate(20);

    
        $sort = $request->get('sort', 'latest');

        $filters = $request->only([
            'city_id',
            'neighborhood_id',
            'property_type_id',
            'purpose',
            'price_min',
            'price_max',
            'area_min',
            'area_max',
            'bathrooms',
            'bedrooms',
        ]);

        $filters['locationName'] = $locationName;

        // // ✅ AJAX Response
        // if ($request->ajax() || $request->wantsJson()) {
        //     return response()->json([
        //         'success'    => true,
        //         'html'       => view('main.properties.partials.property-list', compact('properties'))->render(),
        //         'pagination' => view('main.properties.partials.pagination', compact('properties'))->render(),
        //         'count'      => $properties->total(),
        //     ]);
        // }

        // ✅ Normal View Response
        return view('main.properties.index', [
            'properties'    => $properties,
            'propertyTypes' => $propertyTypes,
            'sections'      => $filterSections,
            'filterRanges'  => $filterRanges,
            'filters'       => $filters,
            'sort'          => $sort,
            'seo'           => $seo,
            'navbarOptions' => ['hide_search' => true, 'full_width' => true],
            'footerOptions' => ['hide' => true],
        ]);
    }

    public function show($slug)
    {

        $id = getIdFromSlug($slug);

        $row = Property::where('id', $id)->firstOrFail();

        $icons = $this->svg_icons();

        $details = [
            // 1) الأهم للمستخدم في قرار الشراء/الإيجار
            [
                'name'  => __('main.property.purpose'),
                'icon'  => $icons['status'],
                'value' => __('main.filters.for_' . $row->purpose),
                'text'  => '',
            ],
            [
                'name'  => __('main.property.type'),
                'icon'  => $icons['faq'],
                'value' => $row->type?->name,
                'text'  => '',
            ],
            [
                'icon'  => '<img src="' . asset('dashboard/images/icons/mtr.svg') . '" alt="">',
                'name'  => __('main.property.area'),
                'value' => $row->area,
                'text'  => __('main.property.square_meter'),
            ],
            [
                'icon'  => $icons['bedrooms'],
                'name'  => __('main.property.bedrooms'),
                'value' => $row->bedrooms,
                'text'  => '',
            ],
            [
                'icon'  => $icons['bathrooms'],
                'name'  => __('main.property.bathrooms'),
                'value' => $row->bathrooms,
                'text'  => '',
            ],
            [
                'name'  => __('main.property.floor'),
                'icon'  => $icons['floor_icon'],
                'value' => $row->floor,
                'text'  => $row->number_of_floors != null ? ' / ' . $row->number_of_floors : '',
            ],
            [
                'name'  => __('main.property.front_view'),
                'icon'  => $icons['front'],
                'value' => $row->facade?->name,
                'text'  => '',
            ],
            [
                'name'  => __('main.property.finishing'),
                'icon'  => $icons['furnishing'],
                'value' => $row->finishingType?->name,
                'text'  => '',
            ],
            [
                'name'  => __('main.property.region'),
                'icon'  => '<img src="' . asset('dashboard/images/icons/map-pin-simple-area.svg') . '">',
                'value' => ($row->city?->name || $row->neighborhood?->name)
                    ? trim(($row->city?->name ?? '') . ' — ' . ($row->neighborhood?->name ?? ''), " —")
                    : null,
                'text'  => '',
            ],

            // 2) بيانات تنظيمية/إدارية (أقل أهمية للمستخدم العادي)
            [
                'name'  => __('main.property.license_number'),
                'icon'  => $icons['info'],
                'value' => $row->license_number,
                'text'  => '',
            ],
            [
                'name'  => __('main.property.plan_number'),
                'icon'  => $icons['info'],
                'value' => $row->plan_number,
                'text'  => '',
            ],
            [
                'name'  => __('main.property.plot_number'),
                'icon'  => $icons['info'],
                'value' => $row->plot_number,
                'text'  => '',
            ],
        ];

        $clientHasInterest = false;

        if (clientHasAuth()) {
            $clientHasInterest = $this->hasDuplicateInterest(clientId(), $id);
        }

        return view('main.properties.show', compact('row', 'details', 'clientHasInterest','icons'));
        
    }

    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////

    private function hasDuplicateInterest(int $clientId, int $propertyId): bool
    {
        return Interest::where('client_id', $clientId)
            ->where('property_id', $propertyId)
            ->whereIn('status', ['new', 'assigned', 'contacted'])
            ->exists();
    }

    private function findExistingClient(?string $email, string $phone, string $countryCode)
    {
        // 1) البحث عبر البريد (إن وُجد)
        if (! empty($email)) {
            $client = Client::where('email', $email)->first();
            if ($client) {
                return $client;
            }
        }

        // 2) البحث عبر رقم الهاتف + كود الدولة
        return Client::where('phone', $phone)
            ->where('country_code', $countryCode)
            ->first();
    }

    private function getClientForInterest(Request $request)
    {
        // 1) لو العميل مسجّل دخول
        if (clientHasAuth()) {
            return Client::find(clientId()); // safe & simple
        }

        // 2) العميل غير مسجّل → نحاول نلاقيه مسبقًا
        $existingClient = $this->findExistingClient(
            $request->email ?? null,
            $request->phone,
            $request->country_code
        );

        if ($existingClient) {
            return $existingClient;
        }

        // 3) لو مفيش عميل → الخطوة 3 هتعمل إنشاء Client جديد
        return null;
    }

    private function createClientForInterest(Request $request)
    {
        return Client::create([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'country_code' => $request->country_code,
            'email'        => $request->email, // nullable OK
            'has_account'  => false,
            'status'       => 1, // not banned
            'source_id'    => Source::where('key', 'property')->where('type', 'client')->value('id'),

        ]);
    }

    private function storeInterestRecord(int $clientId, ?int $propertyId = null, ?string $message = null)
    {
        return Interest::create([
            'client_id'   => $clientId,
            'property_id' => $propertyId,
            'type'        => 'property',
            'message'     => $message,
            'status'      => 'new',
            'is_read'     => false,
        ]);
    }

    public function storeInterest(Request $request, Property $property)
    {
        // ============================
        // Step 0: Validation
        // ============================
        if (! clientHasAuth()) {

            // Validate base fields (without custom phone closure)
            $phoneLengths = phoneNumberLengths();

            $request->validate([
                'message'      => ['nullable', 'string', 'max:1000'],
                'name'         => ['required', 'string', 'min:2', 'max:60'],
                'email'        => ['nullable', 'email', 'max:150'],
                'country_code' => ['required', 'string', Rule::in(array_keys($phoneLengths))],
                'phone'        => ['required', 'string'],
            ]);

            // Normalize phone + throw ValidationException with translated message if invalid
            PhoneNormalizer::normalizeIntoRequest($request);

        } else {

            $request->validate([
                'message' => ['nullable', 'string', 'max:1000'],
            ]);

        }

        // ============================
        // Step 1 + 2: Get Client
        // ============================
        $client = $this->getClientForInterest($request);

        // ============================
        // Step 3: Create Client if not exists
        // ============================
        if (! $client) {
            $client = $this->createClientForInterest($request);
        }

        // ============================
        // Step 4: Prevent duplicate interest
        // ============================
        if ($this->hasDuplicateInterest($client->id, $property->id)) {
            return Response::info(__('main.property.interest_already_registered'), ['style' => 'toastr', 'reset' => true]);
        }

        // ============================
        // Step 5: Store Interest
        // ============================
        $this->storeInterestRecord($client->id, $property->id, $request->message);

        // ============================
        // Step 6: Response
        // ============================
        return Response::success(__('main.property.interest_registered_successfully'), ['style' => 'toastr', 'reset' => true]);
    }

}
