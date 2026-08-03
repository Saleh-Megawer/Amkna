<?php
namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Property\Property;
use App\Models\Property\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PropertyFilterController extends Controller
{

    public static function buildPropertyQuery(Request $request)
    {
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

        $sort = $request->get('sort', 'latest');

        $query = Property::with(['city', 'neighborhood', 'type'])
          //  ->where('approval_status', 'approved')
            ->where('is_archived', false)
            ->filter($filters);

        switch ($sort) {
            case 'price-low':
                $query->orderByRaw('COALESCE(sale_price, rent_price_monthly) ASC');
                break;
            case 'price-high':
                $query->orderByRaw('COALESCE(sale_price, rent_price_monthly) DESC');
                break;
            case 'latest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        return $query;
    }

    public function filterProperties(Request $request)
    {
        $query      = self::buildPropertyQuery($request);
        $properties = $query->paginate(20);

        return response()->json([
            'success'    => true,
            'html'       => view('main.properties.partials.property-grid', compact('properties'))->render(),
            'pagination' => view('main.properties.partials.property-pagination', compact('properties'))->render(),
            'count'      => $properties->total(),
        ]);
    }

    /**
     * Search for cities and neighborhoods (Autocomplete)
     */
    public function searchLocations(Request $request)
    {
        $query = $request->get('q', '');

        // لو الـ query فاضي - نرجع array فاضي
        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'results' => [],
            ]);
        }

        $results = [];

        // البحث في المدن
        $cities = City::whereTranslationLike('name', "%{$query}%")
            ->limit(5)
            ->get();

        foreach ($cities as $city) {
            $results[] = [
                'id'    => $city->id,
                'name'  => $city->name, // هيجيب الـ translation حسب الـ locale
                'type'  => 'city',
                'label' => $city->name . ' (' . __('main.filters.city') . ')',
            ];
        }

        // البحث في الأحياء/المناطق
        $neighborhoods = Neighborhood::with('city')
            ->whereTranslationLike('name', "%{$query}%")
            ->limit(5)
            ->get();

        foreach ($neighborhoods as $neighborhood) {
            $results[] = [
                'id'        => $neighborhood->id,
                'name'      => $neighborhood->name,
                'type'      => 'neighborhood',
                'city_name' => $neighborhood->city->name ?? '',
                'label'     => $neighborhood->name . ' - ' . ($neighborhood->city->name ?? '') . ' (' . __('main.filters.neighborhood') . ')',
            ];
        }

        return response()->json([
            'success' => true,
            'results' => $results,
        ]);
    }

    /**
     * Get filter ranges (cached) property_filter_ranges
     */
    public static function getFilterRanges()
    {
        return Cache::remember('property_filter_ranges', 604800, function () { // Week

            $priceRange = Property::where('approval_status', 'approved')
                ->where('is_archived', false)
                ->selectRaw('
                MIN(LEAST(
                    IFNULL(sale_price, 999999999),
                    IFNULL(rent_price_monthly, 999999999)
                )) as min_price,
                MAX(GREATEST(
                    IFNULL(sale_price, 0),
                    IFNULL(rent_price_monthly, 0)
                )) as max_price
            ')
                ->first();

            $areaRange = Property::where('approval_status', 'approved')
                ->where('is_archived', false)
                ->selectRaw('MIN(area) as min_area, MAX(area) as max_area')
                ->first();

            return [
                'price_min' => $priceRange->min_price ?? 0,
                'price_max' => $priceRange->max_price ?? 10000000,
                'area_min'  => $areaRange->min_area ?? 10,
                'area_max'  => $areaRange->max_area ?? 5000,
            ];

        });
    }

    // property_types_all
    public static function getPropertyTypes()
    {
        return Cache::remember('property_types_all', 604800, function () { // Week
            return PropertyType::select(['id'])->get();
        });
    }

    /**
     * Returns the static sections used in the UI (e.g., Sale / Rent tabs or filters).
     *
     * Each section contains:
     * - name: The label shown to the user
     * - icon: Inline SVG icon (as HTML string) used in the UI
     *
     * Note: This is static config-like data (not from database).
     */
    public static function getFilterSections()
    {
        return [
            'sale' => [
                'name' => __('main.filters.for_sale'),
                'icon' => '<svg width="24px" height="24px" viewBox="0 0 48 48" fill="none" class="" xmlns="http://www.w3.org/2000/svg" aria-label="money-icon"><g clip-path="url(#clip0_166_166946)"><path d="M23.0619 30.5594H25.1079C25.3402 30.5511 25.567 30.6316 25.7421 30.7846C25.9171 30.9376 26.0272 31.1516 26.0499 31.3829C26.066 31.6165 25.9891 31.8469 25.8359 32.024C25.6828 32.201 25.4659 32.3103 25.2324 32.328C25.1825 32.3307 25.1324 32.3307 25.0824 32.328H21.4689C21.1173 32.328 20.78 32.4677 20.5313 32.7163C20.2826 32.965 20.1429 33.3023 20.1429 33.654C20.1429 34.0056 20.2826 34.3429 20.5313 34.5916C20.78 34.8403 21.1173 34.98 21.4689 34.98H22.7544V35.7885C22.766 36.1326 22.9108 36.4588 23.1584 36.6982C23.4059 36.9375 23.7368 37.0714 24.0812 37.0714C24.4255 37.0714 24.7564 36.9375 25.004 36.6982C25.2515 36.4588 25.3964 36.1326 25.4079 35.7885V34.9514C26.2926 34.8757 27.1161 34.4695 27.7147 33.8138C28.3133 33.158 28.6428 32.3009 28.6377 31.413C28.6326 30.5252 28.2932 29.6718 27.6871 29.023C27.0811 28.3742 26.2529 27.9775 25.3674 27.912L25.3584 27.894H23.0979C22.8773 27.8777 22.6706 27.7796 22.5187 27.6188C22.3667 27.458 22.2804 27.2461 22.2766 27.0249C22.2728 26.8037 22.3519 26.589 22.4983 26.4232C22.6448 26.2573 22.8479 26.1522 23.0679 26.1285H26.6169C26.9686 26.1285 27.3059 25.9888 27.5545 25.7401C27.8032 25.4914 27.9429 25.1541 27.9429 24.8025C27.9429 24.4508 27.8032 24.1135 27.5545 23.8648C27.3059 23.6161 26.9686 23.4765 26.6169 23.4765H25.3989V22.7025C25.4049 22.5245 25.375 22.3471 25.311 22.1809C25.2471 22.0147 25.1503 21.8631 25.0265 21.7351C24.9027 21.6071 24.7544 21.5052 24.5905 21.4357C24.4265 21.3662 24.2503 21.3303 24.0722 21.3303C23.8941 21.3303 23.7178 21.3662 23.5539 21.4357C23.3899 21.5052 23.2416 21.6071 23.1178 21.7351C22.994 21.8631 22.8973 22.0147 22.8333 22.1809C22.7693 22.3471 22.7394 22.5245 22.7454 22.7025V23.4975C21.8409 23.5811 21.0034 24.0099 20.4068 24.6948C19.8102 25.3798 19.5004 26.2682 19.5417 27.1756C19.5831 28.083 19.9723 28.9396 20.6287 29.5676C21.2851 30.1955 22.1581 30.5464 23.0664 30.5474L23.0619 30.5594Z" fill="currentColor"></path><path d="M38.0907 26.196C37.0687 23.9432 35.7218 21.8525 34.0932 19.9905C32.67 18.3237 31.0639 16.8223 29.3052 15.5145L32.9847 8.91446C33.1212 8.66735 33.1723 8.38206 33.13 8.10294C33.0876 7.82381 32.9543 7.56651 32.7507 7.37097C32.2837 6.88876 31.7257 6.50381 31.1091 6.23837C30.4925 5.97294 29.8294 5.83226 29.1582 5.82446C28.0828 5.88171 27.0292 6.15034 26.0577 6.61498C25.5388 6.86864 24.9811 7.0334 24.4077 7.10245C24.3256 7.11928 24.2402 7.10711 24.1662 7.06798C22.6718 6.44887 21.0833 6.08724 19.4682 5.99846C18.5503 6.0084 17.6445 6.20842 16.8078 6.58586C15.971 6.9633 15.2216 7.50998 14.6067 8.19147C14.3903 8.4038 14.2556 8.68557 14.2263 8.98729C14.1969 9.28901 14.2748 9.59143 14.4462 9.84148L18.3627 15.5789C16.6433 16.8704 15.07 18.3456 13.6707 19.9785C12.0441 21.8443 10.6947 23.9348 9.66417 26.1855C8.45632 28.8452 7.82941 31.7318 7.8252 34.653C7.86345 36.6047 8.67079 38.4625 10.0717 39.8221C11.4725 41.1817 13.3536 41.9331 15.3057 41.913H32.4282C34.3803 41.9343 36.2617 41.1831 37.6624 39.8232C39.063 38.4633 39.8694 36.6049 39.9057 34.653C39.9081 31.7371 39.2894 28.8541 38.0907 26.196ZM20.6442 17.217H27.1227C28.9505 18.5016 30.6074 20.0138 32.0532 21.717C35.2871 25.2578 37.1158 29.8582 37.1952 34.653C37.1809 35.871 36.6921 37.0354 35.8327 37.8987C34.9734 38.762 33.8111 39.2561 32.5932 39.276H15.3222C14.082 39.2888 12.887 38.8111 11.9975 37.9469C11.108 37.0827 10.5961 35.902 10.5732 34.662C10.6543 29.8615 12.4861 25.2559 15.7242 21.711C17.1717 20.0149 18.8243 18.5054 20.6442 17.217ZM26.7252 14.5665H20.9592L17.3592 9.31647C17.9605 8.86599 18.6913 8.62189 19.4427 8.62048C20.7395 8.70774 22.0121 9.01458 23.2062 9.52795C23.6005 9.66091 24.0141 9.72733 24.4302 9.72447H24.4422C25.3798 9.6627 26.2966 9.42024 27.1422 9.01045C27.7769 8.69742 28.4639 8.50418 29.1687 8.44045C29.4652 8.44192 29.7577 8.50904 30.0252 8.63696L26.7252 14.5665Z" fill="currentColor"></path></g><defs><clipPath id="clip0_166_166946"><rect width="48" height="48" fill="white" transform="translate(0.000976562)"></rect></clipPath></defs></svg>',
            ],
            'rent' => [
                'name' => __('main.filters.for_rent'),
                'icon' => '<svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="doller-icon" role="doller-icon" class=""><g clip-path="url(#clip0_166_172876)"><path d="M6 8.25H3V5.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.4668 19.924C8.3668 20.445 9.3638 20.814 10.4258 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3.48242 15.173C3.8426 16.1675 4.37393 17.0915 5.05242 17.903" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M13.5742 21C14.6161 20.8179 15.6177 20.4537 16.5332 19.924" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18.9473 17.903C19.6258 17.0915 20.1571 16.1675 20.5173 15.173" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M21.0002 12C21.0002 9.61305 20.052 7.32387 18.3641 5.63604C16.6763 3.94821 14.3871 3 12.0002 3C8.37017 3 5.24917 5.154 3.82617 8.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 9.137V8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 14.864V15.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10.3438 14.181C10.5908 14.586 11.0128 14.865 11.5238 14.865H12.5698C12.8976 14.866 13.2143 14.7469 13.4602 14.5301C13.706 14.3133 13.8639 14.014 13.9039 13.6887C13.9439 13.3634 13.8633 13.0347 13.6774 12.7648C13.4915 12.4949 13.213 12.3025 12.8948 12.224L11.1048 11.774C10.7884 11.6939 10.5121 11.501 10.3278 11.2316C10.1435 10.9621 10.0638 10.6347 10.1039 10.3107C10.1439 9.98675 10.3008 9.68853 10.5451 9.47205C10.7894 9.25557 11.1044 9.13572 11.4308 9.13501H12.4778C12.9868 9.13501 13.4088 9.41401 13.6548 9.81801" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g><defs><clipPath id="clip0_166_172876"><rect width="24" height="24" fill="white"></rect></clipPath></defs></svg>',
            ],
        ];
    }

}
