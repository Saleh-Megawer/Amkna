<?php
namespace App\Http\Controllers\Dashboard\Property;

use App\Helpers\File;
use App\Helpers\FileUploader;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\PropertyUnits;
use App\Models\Property\Property;
use App\Traits\Property\HandlesPropertyData;
use Illuminate\Http\Request;

class PropertyUnitsController extends Controller
{

    use HandlesPropertyData;

    // Upload Options For Image
    const PATH      = 'properties/units';
    const SMALL     = '400*300*75';
    const EXTENSION = 'webp';
    const HASH_NAME = false;

    /**
     * Display properties listing with filters.
     */
    public function index(Property $property)
    {

        $property->load('units');

        return view('dashboard.property.units', [
            'row'      => $property,
            'linksMap' => $this->linksMap(),
        ]);
    }

    public function show(Property $property, $unit)
    {
        return response()->json(PropertyUnits::where('id', $unit)->first());
    }

    public function store(Request $request, Property $property)
    {

        $data = $request->validate([
            'image'       => 'nullable|max:3072|mimes:' . mimesType('image_accept_resize'),
            'unit_number' => 'required|max:40',
            'price'       => 'required|min:1|max:100000000|numeric',
            'area'        => 'required|min:40|max:10000|numeric',
            'bedrooms'    => 'required|min:1|max:100|numeric',
            'bathrooms'   => 'required|min:1|max:100|numeric',
        ]);

        // Upload Image Item
        $data['image'] = FileUploader::upload('image', [
            'path'      => self::PATH,
            'extension' => self::EXTENSION,
            'hash'      => self::HASH_NAME,
            'max_width' => 720,
            'quality'   => 70,
        ]);

        $data['property_id'] = $property->id;
        $data['admin_id']    = adminId();

        PropertyUnits::create($data);

        return Response::success('تم اضافة النموذج بنجاح...', ['style' => 'toastr', 'reset' => true]);

    }

    public function update(Request $request, PropertyUnits $productItems)
    {

        $row = $productItems->where('id', $request->item_id)->first();

        if ($row == null) {
            return Response::error('البيانات المطلوبة غير متاحة', ['style' => 'toastr']);
        }

        $data = $request->validate([
            'image'       => 'nullable|max:3072|mimes:' . mimesType('image_accept_resize'),
            'unit_number' => 'required|max:60',
            'price'       => 'required|min:1|max:100000000|numeric',
            'area'        => 'required|min:45|max:10000|numeric',
            'bedrooms'    => 'required|min:1|max:100|numeric',
            'bathrooms'   => 'required|min:1|max:100|numeric',
        ]);

        // Upload Image Item
        $data['image'] = FileUploader::upload('image', [
            'path'      => self::PATH,
            'extension' => self::EXTENSION,
            'hash'      => self::HASH_NAME,
            'small'     => self::SMALL,
            'max_width' => 1200,
            'quality'   => 75,
            'delete'    => $row->image,
        ]);

        $row->update($data);

        return Response::success('تم تحديث النموذج بنجاح...', ['style' => 'toastr', 'reload' => true, 'time_out' => 0.5]);
    }

    public function destroy(Property $property,$unit)
    {
        // Get Row And Check IF IN Database
        $row = PropertyUnits::where('id', $unit)->firstOrFail();

        File::delete(self::PATH, $row->image);

        // Delete From DB
        $row->delete();

        //Message
        return Response::success('تم حذف النموذج بنجاح', ['style' => 'toastr']);

    }

}
