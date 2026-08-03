<?php
namespace App\Http\Controllers\Dashboard;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:city_view'], ['only' => 'index']);
        $this->middleware(['permission:city_create'], ['only' => 'store']);
        $this->middleware(['permission:city_edit'], ['only' => 'update']);
        $this->middleware(['permission:city_delete'], ['only' => 'destroy']);
    }

    private $validateAttr = [];

    // Show All Rows
    public function index()
    {

        $rows = City::with('by')->orderByDesc('id')->get();

        // Check IF Have Edit
        $id = intval(request('edit'));

        if ($id != 0) {
            $editRow = City::where('id', $id)->first();
            // Form Update Options
            $formOption = [
                'panelTitle'   => 'تحديث بيانات المدينة',
                'submitButton' => 'تحديث',
                'formAction'   => route('cities-update'),
            ];

            if ($editRow == null) {
                return redirect(adminUrl('cities'))->with('warning', 'البيانات المطلوبة غير متاحة في النظام');
            }
        } else {

            // Form Create Options
            $editRow    = [];
            $formOption = [
                'panelTitle'   => 'اضافة مدينة جديدة',
                'submitButton' => 'اضافة',
                'formAction'   => route('cities-store'),
            ];
        }

        return view('dashboard.cities.index', compact('rows', 'editRow', 'formOption'));
    }

    // Insert New Row
    public function store(Request $request, City $cities)
    {

        // Prepare Input Validation
        $this->validateAttr = array_merge(
            collect(languages())->flatMap(function ($val, $key) use ($cities) {
                return [
                    "$key*.name" => 'required|max:150|min:2|unique:cities_translations,name,NULL,id,locale,' . $key,
                    //"$key*.desc" => 'nullable|max:255',
                ];
            })->toArray()
        );

        // Validate
        $data = $request->validate($this->validateAttr);

        // Add New Attr
        $data['created_by'] = adminId();

        // Insert
        $cities->create($data);

        return Response::success('تم اضافة المدينة بنجاح...', ['style' => 'toastr', 'reset' => true, 'reload' => true, 'time_out' => 2]);
    }

    // Update Row
    public function update(Request $request)
    {

        $row = City::where('id', $request->id)->first();

        // Check If Not Exists in db
        if ($row == null) {
            return Response::error('البيانات المطلوبة غير متوفرة في النظام', ['style' => 'toastr']);
        }

        // Validate Data
        $this->validateAttr = array_merge(
            collect(languages())->flatMap(function ($val, $key) use ($row) {
                return [
                    "$key*.name" => 'required|max:150|min:2|unique:cities_translations,name,' . ($row->id ?? 'NULL') . ',city_id,locale,' . $key,
                    "$key*.desc" => 'nullable|max:255',
                ];
            })->toArray()
        );

        $data = $request->validate($this->validateAttr);

        // Insert
        $row->update($data);

        // Return Message
        return Response::success('تم تحديث المدينة بنجاح...', ['style' => 'toastr', 'redirect' => adminUrl('cities'), 'reload' => true, 'time_out' => 2]);
    }

    // Delete Row
    public function destroy()
    {
        // Get Row And Check IF IN Database
        $row = City::find(request('id'));

        // Check If Not Exist The Row IN Database
        if (empty($row)) {
            // Message
            return Response::error('هذه العملية غير مصرح بها، وقد لا تكون البيانات المطلوبة متاحة في النظام', ['style' => 'toastr']);
        } else {
            // Delete From DB
            $row->delete();
            //Message
            return Response::success('تم حذف البيانات بنجاح', ['style' => 'toastr']);
        }
    }

} // End Class
