<?php
namespace App\Http\Controllers\Dashboard\Property;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Property\PropertyFinishingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FinishingTypeController extends Controller
{

    private $validateAttr = [];

    public function __construct()
    {
        $this->middleware(['permission:property_furnishing_view'], ['only' => ['index']]);
        $this->middleware(['permission:property_furnishing_create'], ['only' => ['store']]);
        $this->middleware(['permission:property_furnishing_edit'], ['only' => ['update']]);
        $this->middleware(['permission:property_furnishing_delete'], ['only' => ['destroy']]);
    }

    public function routes($route)
    {
        $routes = [
            'index'   => route('properties.finishing.index'),
            'update'  => route('properties.finishing.update'),
            'store'   => route('properties.finishing.store'),
            'destroy' => route('properties.finishing.destroy'),
        ];

        return $routes[$route];
    }

    public function model()
    {
        return (new PropertyFinishingType);
    }

    // Show All Rows
    public function index()
    {

        $rows = $this->model()::with('admin')->orderByDesc('id')->get();

        $destroyRoute = $this->routes('destroy');

        // Check IF Have Edit
        $id = intval(request('edit'));

        if ($id != 0) {
            $editRow = $this->model()::where('id', $id)->first();

   
            // Form Update Options
            $formOption = [
                'panelTitle'   => 'تحديث نوع تشطيب',
                'submitButton' => 'تحديث',
                'formAction'   => $this->routes('update'),
            ];

            if ($editRow == null) {
                return redirect($this->routes('index'))->with('warning', 'البيانات المطلوبة غير متاحة في النظام');
            }
        } else {

            // Form Create Options
            $editRow    = [];
            $formOption = [
                'panelTitle'   => 'اضافة نوع تشطيب جديد',
                'submitButton' => 'اضافة',
                'formAction'   => $this->routes('store'),
            ];
        }

        return view('dashboard.property.finishing.finishing', compact('rows', 'editRow', 'formOption', 'destroyRoute'));
    }

    // Insert New Row
    public function store(Request $request)
    {

        // Prepare Input Validation
        $this->validateAttr = array_merge(
            collect(languages())->flatMap(function ($val, $key) {
                return [
                    "$key*.name" => 'required|max:60|min:2',
                ];
            })->toArray()
        );

        // Validate input fields
        $data = $request->validate($this->validateAttr);

        // Generate slug from English name
        $slug = Str::slug($data['en']['name']);

        // Validate slug uniqueness
        $validator = Validator::make(
            ['slug' => $slug],
            ['slug' => 'unique:' . $this->model()->table . ',slug']
        );

        if ($validator->fails()) {
            return Response::error('نوع التشطيب مستخدم مسبقاً.', ['style' => 'toastr']);
        }

        // Final data
        $data['slug']     = $slug;
        $data['admin_id'] = adminId();

        // Insert
        $this->model()->create($data);

        return Response::success('تم اضافة نوع التشطيب بنجاح', ['style' => 'toastr', 'reset' => true, 'reload' => true, 'time_out' => 1]);
    }

    // Update Row
    public function update(Request $request)
    {

        $row = $this->model()::where('id', $request->id)->first();

        // Check If Not Exists in db
        if ($row == null) {
            return Response::error('البيانات المطلوبة غير متوفرة في النظام', ['style' => 'toastr']);
        }

        // Prepare Input Validation
        $this->validateAttr = array_merge(
            collect(languages())->flatMap(function ($val, $key) {
                return [
                    "$key*.name" => 'required|max:60|min:2',
                ];
            })->toArray()
        );

        // Validate input fields
        $data = $request->validate($this->validateAttr);

        // Generate slug from English name
        $slug = Str::slug($data['en']['name']);

        // Validate slug unique
        $validator = Validator::make(
            ['slug' => $slug],
            ['slug' => 'unique:' . $this->model()->table . ',slug,' . $row->id]
        );

        if ($validator->fails()) {
            return Response::error('وسيلة الراحة مستخدمة مسبقاً.', ['style' => 'toastr']);
        }

        // Insert
        $row->update($data);

        // Return Message
        return Response::success('تم تحديث نوع التشطيب بنجاح', ['style' => 'toastr', 'redirect' => $this->routes('index'), 'reload' => true, 'time_out' => 1]);
    }

    // Delete Row
    public function destroy()
    {
        // Get Row And Check IF IN Database
        $row = $this->model()::find(request('id'));

        // Check If Not Exist The Row IN Database
        if (empty($row)) {
            // Message
            return Response::error('هذه العملية غير مصرح بها، وقد لا تكون البيانات المطلوبة متاحة في النظام', ['style' => 'toastr']);
        } else {
            // Delete From DB
            $row->delete();
            //Message
            return Response::success('تم حذف نوع التشطيب بنجاح', ['style' => 'toastr']);
        }
    }

} // End Class
