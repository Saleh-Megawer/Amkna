<?php
namespace App\Http\Controllers\Dashboard\Property;

use App\Enums\Property\PropertyAvailabilityStatus;
use App\Helpers\FileUploader;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Property\StorePropertyRequest;
use App\Http\Requests\Property\UpdatePropertyRequest;
use App\Models\Property\Property;
use App\Traits\Property\FindsPropertyByUuid;
use App\Traits\Property\HandlesPropertyData;
use App\Traits\Property\HasPropertyTabs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    use HasPropertyTabs, HandlesPropertyData, FindsPropertyByUuid;

    
    /**
     * Register permissions middleware and initialize tabs.
     */
    public function __construct()
    {
        $this->bootTabs();

        // View & filter properties
        $this->middleware(['permission:properties_view_all'], ['only' => 'index']);

        // Create property
        $this->middleware(['permission:properties_create'], ['only' => 'store']);

        // Edit & update property
        $this->middleware(['permission:properties_edit'], ['only' => ['edit', 'update', 'uploadMainImage']]);

        // Delete property (future-ready)
        $this->middleware(['permission:properties_delete'], ['only' => 'destroy']);
    }

    /**
     * Display properties listing with filters.
     */
    public function index()
    {
        // Collect search filters from request
        $filters = request()->only([
            'title',
            'neighborhood_id',
            'property_type_id',
            'property_status_id',
            'furnishing_status_id',
            'price_min',
            'price_max',
            'bathrooms',
            'bedrooms',
            'is_archived',
        ]);

        // Default archive filter
        if (! array_key_exists('is_archived', $filters)) {
            $filters['is_archived'] = 0;
        }

        // Fetch properties with optimized select
        $properties = Property::select(
            'id',
            'uuid',
            'main_image',
            'area',
            'purpose',
            'sale_price',
            'rent_price_monthly',
            'bedrooms',
            'bathrooms',
            'title_normalized_ar',
            'description_normalized_ar',
            'admin_id',
            'city_id',
            'neighborhood_id',
            'views_count',
            'created_at',
            'is_archived',
            'availability_status',
        )
            ->with(['city', 'neighborhood'])
            ->orderByDesc('id')
            ->filter($filters)
            ->paginate(25);

        /**
         * Human readable search labels
         */
        $search_keys = [
            'property_type'              => 'نوع العقار',
            'property_status'            => 'حالة العقار',
            'property_finishing_type_id' => 'مستوي التأسيس',
            'price'                      => 'السعر',
            'bedrooms'                   => 'عدد الغرف',
            'bathrooms'                  => 'عدد الحمامات',
            'neighborhood'               => 'الحي',
        ];

        // Archived vs active counters
        $counts = Property::selectRaw('
            SUM(is_archived = 1) as archived,
            SUM(is_archived = 0) as active
        ')->first();

        return view(
            'dashboard.property.index',
            array_merge(
                $this->getViewData(),
                [
                    'properties'  => $properties,
                    'counts'      => $counts,
                    'search_keys' => $search_keys,
                    'filters'     => $filters,
                ]
            )
        );
    }

    /**
     * Store new property.
     */
    public function store(StorePropertyRequest $request)
    {
        // Retrieve validated data
        $data = $request->validated();

        // Normalize titles for search optimization
        $data['title_normalized_ar'] = normalizeArabic($data['ar']['title']);
        $data['title_normalized_en'] = Str::lower($data['en']['title']);

        // Create property record
        $property = Property::create($data);

        // Return success response
        return Response::success(
            'تم إضافة الوحدة بنجاح...',
            [
                'style'    => 'toastr',
                'reset'    => true,
                'redirect' => route('properties.edit', $property->uuid),
                'time_out' => 2,
            ]
        );
    }

    /**
     * Show edit property page.
     */
    public function edit($uuid)
    {
        $row = Property::where('uuid', $uuid)->firstOrFail();

        return view(
            'dashboard.property.edit',
            array_merge(
                $this->getViewData(['city_id' => $row->city_id]),
                [
                    'row'                => $row,
                    'availabilityStatus' => PropertyAvailabilityStatus::options(),
                ]
            )
        );
    }

    /**
     * Update existing property.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $data = $request->validated();

        // Extract base fields
        $baseData = collect($data)->except(['feature_id', 'amenity_id'])->toArray();

        // Normalize searchable fields
        $baseData['title_normalized_ar']       = normalizeArabic($data['ar']['title']);
        $baseData['title_normalized_en']       = Str::lower($data['en']['title']);
        $baseData['description_normalized_ar'] = normalizeArabic($data['ar']['description']);
        $baseData['description_normalized_en'] = Str::lower($data['en']['description']);

        // Archive flag handling
        $baseData['is_archived'] = $request->boolean('is_archived');

        // Update main property record
        $property->update($baseData);

        // Sync relations
        $property->features()->sync($data['feature_id'] ?? []);
        $property->amenities()->sync($data['amenity_id'] ?? []);

        return Response::success('تم تحديث الوحدة بنجاح...', ['style' => 'toastr']);
    }

    /**
     * Upload or replace property main image.
     */
    public function uploadMainImage(Request $request)
    {
        $propertyId = $this->getPropertyId();

        if (! $propertyId) {
            return Response::error(
                'الوحدة العقارية المطلوبة غير متاحة في النظام',
                ['style' => 'toastr']
            );
        }

        // Fetch current image
        $property = Property::where('id', $propertyId)
            ->select('main_image')
            ->first();

        // Validate uploaded image
        $request->validate([
            'main_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        try {

            // Upload image using centralized helper
            $fileName = FileUploader::upload('main_image', [
                'path'      => Property::PATH,
                'max_width' => 1400,
                'quality'   => 70,
                'medium'    => Property::MEDIUM,
                'small'     => Property::SMALL,
                'delete'    => $property->main_image,
                'hash'      => Property::HASH_NAME,
                'extension' => Property::EXTENSION,
            ]);

            Property::where('id', $propertyId)->update([
                'main_image' => $fileName,
            ]);

            return response()->json([
                'success'     => true,
                'property_id' => $propertyId,
                'fileName'    => $fileName,
            ]);

        } catch (\Exception $e) {
            // \Log::error($e->getMessage(), ['exception' => $e]);
            return response()->json([
                'status'  => false,
                'message' => 'Upload failed',
            ], 500);
        }
    }
}
