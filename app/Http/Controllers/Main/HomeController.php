<?php
namespace App\Http\Controllers\Main;

use App\Helpers\PhoneNormalizer;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Admin\AdminHelpers;
use App\Models\Faqs\Faqs;
use App\Models\Neighborhood;
use App\Models\Pages;
use App\Models\Privacy\Privacy;
use App\Models\Property\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    use AdminHelpers;

    ///////////////////////////////////////////////////
    public function index()
    {

        $row = Pages::where('page', 'home')->first();

        // Filter the array based on the value in the "lang" key
        $headerSliderTitleDesc = collect(json_decode($row->header_title_desc, true))
            ->where('lang', lang())
            ->whenEmpty(fn($c) => collect([
                [
                    "title" => 'Find Your Property in\r\nEgypt with Sahd',
                    "desc"  => null,
                ],
            ]))
            ->random(null);
        //
        $headerImages      = collect(json_decode($row->slider, true))->random();
        $headerRandomImage = isset($headerImages['file_name']) ?
        largeAsset('pages/home/' . $headerImages['file_name']) :
        asset('assets/images/default/default-banner-home.png');

        ////////////////////

        // Get Latest Property
        // $latestProperties = Property::orderByDesc('id')->limit(24)->get();

        // $latestProperties = Property::select([
        //     'id', 'main_image', 'area', 'purpose', 'sale_price', 'rent_price_monthly',
        //     'bedrooms', 'bathrooms', 'is_archived', 'city_id', 'neighborhood_id',
        // ])->with(['city:id', 'neighborhood:id'])
        //     ->orderByDesc('id')
        //     ->limit(24)
        //     ->get();

        // 1. Latest 8 properties
        $latestProperties = Property::with(['city', 'neighborhood'])
        // ->where('approval_status', 'approved')
            ->where('is_archived', false)
            ->latest()
            ->limit(4)
            ->get();

        // 2. Most viewed properties
        $mostViewedProperties = Property::with(['city', 'neighborhood'])
        //   ->where('approval_status', 'approved')
            ->where('is_archived', false)
            ->orderBy('views_count', 'desc')
            ->limit(12)
            ->get();

        // 3. Rent properties
        $rentProperties = Property::with(['city', 'neighborhood'])
        // ->where('approval_status', 'approved')
            ->where('is_archived', false)
            ->where('purpose', 'rent')
            ->latest()
            ->limit(12)
            ->get();

        // 4. Sale properties
        $saleProperties = Property::with(['city', 'neighborhood'])
        //  ->where('approval_status', 'approved')
            ->where('is_archived', false)
            ->where('purpose', 'sale')
            ->latest()
            ->limit(12)
            ->get();

        // 5. Neighborhoods
        $neighborhoods = Neighborhood::with('city')->get();

        /////////////////////////////////////////////
        /////////////////////////////////////////////
        $filterSections = PropertyFilterController::getFilterSections();
        $filterRanges   = PropertyFilterController::getFilterRanges();
        $propertyTypes  = PropertyFilterController::getPropertyTypes();

        return view('main.home', [
            'headerRandomImage'     => $headerRandomImage,
            'headerSliderTitleDesc' => $headerSliderTitleDesc,
            'latestProperties'      => $latestProperties,
            'mostViewedProperties'  => $mostViewedProperties,
            'rentProperties'        => $rentProperties,
            'saleProperties'        => $saleProperties,
            'neighborhoods'         => $neighborhoods,

            'navbarOptions'         => ['hide_search' => true],
            ///
            'sections'              => $filterSections,
            'propertyTypes'         => $propertyTypes,

        ]);

    }

    public function about()
    {

        $stats = [
            'properties'   => 5000,
            'clients'      => 12000,
            'cities'       => 25,
            'satisfaction' => 98,
        ];
        return view('main.about', compact('stats'));

    }

    public function privacyPolicy()
    {
        $row = Privacy::firstOrCreate();
        return view('main.privacy-policy', compact('row'));

    }

    public function faqs()
    {
        $rows = Faqs::get();

        return view('main.faqs', compact('rows'));

    }

    public function registerMarketer(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Normalize phone number into a consistent local format
        | - Validates country code
        | - Removes non-digits
        | - Removes leading trunk zero
        | - Replaces request phone with normalized value
        |--------------------------------------------------------------------------
        */

        PhoneNormalizer::normalizeIntoRequest($request);

        $phoneLengths = phoneNumberLengths();

        $data = $request->validate([
            'country_code'      => ['required', 'string', Rule::in(array_keys($phoneLengths))],
            'phone'             => ['required', 'string'],
            //
            'f_name'            => 'required|max:20|min:2',
            'l_name'            => 'required|max:20|min:2',
            'email'             => 'required|email|max:255|unique:admins,email',
            'marketing_license' => 'required|max:100',
        ], [
            'email.email'           => msg('auth.register.email_invalid'),
            'email.max'             => msg('auth.register.email_invalid'),

            'country_code.required' => msg('auth.register.country_code_required'),
            'country_code.in'       => msg('auth.register.country_code_invalid'),

            'phone.required'        => msg('auth.register.phone_required'),
        ]);

        $insert = $this->model()->create([
            'f_name'              => Str::headline($data['f_name']),
            'l_name'              => Str::headline($data['l_name']),
            'full_name'           => Str::headline($data['f_name']) . ' ' . Str::headline($data['l_name']),
            'type'                => 'sales',
            'status'              => '0',
            'is_available'        => false,
            'phone'               => $data['country_code'] . $data['phone'],
            'password'            => Hash::make(Str::random(12)),
            'email'               => $data['email'],
            'is_marketer_request' => true,
            'marketing_license'   => $data['marketing_license'],
        ]);

        $insert->assignRole('sales');

        $this->createAdminTables($insert->id);

        return Response::success(__('register_marketer.success'), [
            'style' => 'toastr',
            'reset' => true,
        ]);
    }

}
