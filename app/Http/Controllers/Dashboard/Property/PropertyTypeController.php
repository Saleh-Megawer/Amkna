<?php
namespace App\Http\Controllers\Dashboard\Property;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Property\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:property_types_view')->only('index');
        $this->middleware('permission:property_types_create')->only('store');
        $this->middleware('permission:property_types_edit')->only('update');
        $this->middleware('permission:property_types_delete')->only('destroy');
    }

    private $validateAttr = [];

    // Show All Rows
    public function index()
    {

        $rows = PropertyType::with('by')->orderByDesc('id')->get();

        // Check IF Have Edit
        $id = intval(request('edit'));
        // Form Create Options
        $editRow = [];

        if ($id != 0) {

            $editRow = PropertyType::where('id', $id)->first();

            // Form Update Options
            $formOption = [
                'panelTitle'   => 'تحديث نوع عقاري',
                'submitButton' => 'تحديث',
                'formAction'   => route('properties.types.update'),
            ];

            if ($editRow == null) {
                return redirect(route('properties.types.index'))->with('warning', 'البيانات المطلوبة غير متاحة في النظام');
            }

        } else {

            $formOption = [
                'panelTitle'   => 'اضافة نوع عقاري جديد',
                'submitButton' => 'اضافة',
                'formAction'   => route('properties.types.store'),
            ];
        }

        return view('dashboard.property.types.index', compact('rows', 'editRow', 'formOption'));
    }

    // Insert New Row
    public function store(Request $request, PropertyType $cities)
    {

        // Prepare Input Validation
        $this->validateAttr = array_merge(
            collect(languages())->flatMap(function ($val, $key) use ($cities) {
                return [
                    "$key*.name" => 'required|max:60|min:2',
                    "$key*.desc" => 'nullable|max:500',
                ];
            })->toArray()
        );

        // Validate
        $data = $request->validate($this->validateAttr);

        // Add New Attr
        $data['created_by'] = adminId();

        // Insert
        $cities->create($data);

        return Response::success('تم اضافة النوع العقاري بنجاح...', ['style' => 'toastr', 'reset' => true, 'reload' => true, 'time_out' => 2]);
    }

    // Update Row
    public function update(Request $request)
    {

        $row = PropertyType::where('id', $request->id)->first();

        // Check If Not Exists in db
        if ($row == null) {
            return Response::error('البيانات المطلوبة غير متوفرة في النظام', ['style' => 'toastr']);
        }

        // Validate Data
        $this->validateAttr = array_merge(
            collect(languages())->flatMap(function ($val, $key) use ($row) {
                return [
                    "$key*.name" => 'required|max:60|min:2',
                    "$key*.desc" => 'nullable|max:500',
                ];
            })->toArray()
        );

        $data = $request->validate($this->validateAttr);

        // Insert
        $row->update($data);

        // Return Message
        return Response::success('تم تحديث النوع العقاري بنجاح...', ['style' => 'toastr', 'redirect' => route('properties.types.index'), 'time_out' => 2]);
    }

    // Delete Row
    public function destroy()
    {
        // Get Row And Check IF IN Database
        $row = PropertyType::find(request('id'));

        // Check If Not Exist The Row IN Database
        if (empty($row)) {
            // Message
            return Response::error('هذه العملية غير مصرح بها، وقد لا تكون البيانات المطلوبة متاحة في النظام');
        } else {
            // Delete From DB
            $row->delete();
            //Message
            return Response::success('تم حذف البيانات بنجاح', ['style' => 'toastr']);
        }
    }

} // End Class
