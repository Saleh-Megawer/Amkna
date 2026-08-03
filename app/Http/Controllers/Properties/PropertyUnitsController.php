<?php
namespace App\Http\Controllers\Properties;

use App\Helpers\File;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\PropertyUnits;
use Illuminate\Http\Request;

class PropertyUnitsController extends Controller
{

    // Upload Options For Image
    const PATH = 'properties/units';
    // const LARGE     = '1232*753*75';
    const SMALL     = '161*95*70';
    const EXTENSION = 'webp';
    const HASH_NAME = false;

    public function __construct()
    {
        $this->middleware(['permission:properties_create'], ['only' => ['store', 'update', 'destroy']]);
    }

    public function getRow()
    {
        return response()->json(PropertyUnits::where('id', request('id'))->first());
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'image'     => 'nullable|max:3072|mimes:' . mimesType('image_accept_resize'),
            'name'      => 'required|max:60',
            'price'     => 'required|min:1|max:100000000|numeric',
            'area'      => 'required|min:45|max:10000|numeric',
            'bedrooms'  => 'required|min:1|max:100|numeric',
            'bathrooms' => 'required|min:1|max:100|numeric',
        ]);

        // Upload Image Item
        $data['image'] = File::upload('image', [
            'path'      => self::PATH,
            'extension' => self::EXTENSION,
            'hash'      => self::HASH_NAME,
            'small'     => self::SMALL,
            'real_size' => false,
        ]);

        $data['property_id'] = $request->id;
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
            'image'     => 'nullable|max:3072|mimes:' . mimesType('image_accept_resize'),
            'name'      => 'required|max:60',
            'price'     => 'required|min:1|max:100000000|numeric',
            'area'      => 'required|min:45|max:10000|numeric',
            'bedrooms'  => 'required|min:1|max:100|numeric',
            'bathrooms' => 'required|min:1|max:100|numeric',
        ]);

        // Upload Image Item
        $data['image'] = File::upload('image', [
            'path'      => self::PATH,
            'extension' => self::EXTENSION,
            'hash'      => self::HASH_NAME,
            'small'     => self::SMALL,
            'real_size' => false,
            'delete'    => $row->image,
        ]);

        $row->update($data);

        return Response::success('تم تحديث النموذج بنجاح...', ['style' => 'toastr', 'reload' => true, 'time_out' => 0.5]);
    }

    public function destroy()
    {
        // Get Row And Check IF IN Database
        $row = PropertyUnits::find(request('id'));

        File::delete(self::PATH . '/units', $row->image);

        // Delete From DB
        $row->delete();

        //Message
        return Response::success('تم حذف النموذج بنجاح', ['style' => 'toastr']);

    }

}
