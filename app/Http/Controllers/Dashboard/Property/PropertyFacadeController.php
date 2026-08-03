<?php
namespace App\Http\Controllers\Dashboard\Property;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Property\PropertyFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PropertyFacadeController extends Controller
{

   

    private $validateAttr = [];

    // Show All Rows
    public function index()
    {

        $rows = PropertyFacade::with('by')->orderByDesc('id')->get();

        // Check IF Have Edit
        $id = intval(request('edit'));
        // Form Create Options
        $editRow = [];

        if ($id != 0) {

            $editRow = PropertyFacade::where('id', $id)->first();

            // Form Update Options
            $formOption = [
                'panelTitle'   => 'تحديث واجهة',
                'submitButton' => 'تحديث',
                'formAction'   => route('properties.facades.update'),
            ];

            if ($editRow == null) {
                return redirect(route('properties.facades.index'))->with('warning', 'البيانات المطلوبة غير متاحة في النظام');
            }

        } else {

            $formOption = [
                'panelTitle'   => 'إضافة واجهة جديدة',
                'submitButton' => 'اضافة',
                'formAction'   => route('properties.facades.store'),
            ];
        }

        return view('dashboard.property.facades.index', compact('rows', 'editRow', 'formOption'));
    }

    // Insert New Row
    public function store(Request $request, PropertyFacade $facades)
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
            ['slug' => 'unique:property_facades,slug']
        );

        if ($validator->fails()) {
            return Response::error('اسم الواجهة مستخدم مسبقاً.', ['style' => 'toastr']);
        }

        // Final data
        $data['slug']       = $slug;
        $data['created_by'] = adminId();

        // Insert
        $facades->create($data);

        return Response::success(
            'تم إضافة الواجهة بنجاح...',
            ['style' => 'toastr', 'reset' => true, 'reload' => true, 'time_out' => 2]
        );
    }

    // Update Row
    public function update(Request $request)
    {
        $row = PropertyFacade::where('id', $request->id)->first();

        // Check If Not Exists in db
        if ($row == null) {
            return Response::error('البيانات المطلوبة غير متوفرة في النظام', ['style' => 'toastr']);
        }

        // Prepare Validation Rules
        $this->validateAttr = array_merge(
            collect(languages())->flatMap(function ($val, $key) {
                return [
                    "$key*.name" => 'required|max:60|min:2',
                ];
            })->toArray()
        );

        // Validate translated fields
        $data = $request->validate($this->validateAttr);

        // Generate new slug based on English name
        $slug = Str::slug($data['en']['name']);

        // Validate slug uniqueness (ignore current row)
        $validator = Validator::make(
            ['slug' => $slug],
            [
                'slug' => Rule::unique('property_facades', 'slug')->ignore($row->id),
            ]
        );

        if ($validator->fails()) {
            return Response::error('اسم الواجهة مستخدم مسبقًا.', ['style' => 'toastr']);
        }

        // Merge updated fields
        $data['slug'] = $slug;

        // Update
        $row->update($data);

        // Return success
        return Response::success(
            'تم تحديث الواجهة بنجاح...',
            ['style' => 'toastr', 'redirect' => route('properties.facades.index'), 'time_out' => 2]
        );
    }

    // Delete Row
    public function destroy()
    {
        // Get Row And Check IF IN Database
        $row = PropertyFacade::find(request('id'));

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
