<?php
namespace App\Http\Controllers\Dashboard;

use App\Helpers\FileUploader;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:neighborhood_view'], ['only' => 'index']);
        $this->middleware(['permission:neighborhood_create'], ['only' => 'store']);
        $this->middleware(['permission:neighborhood_edit'], ['only' => 'update']);
        $this->middleware(['permission:neighborhood_delete'], ['only' => 'destroy']);
    }

    private $validateAttr = [];

    // Upload Options For Image
    const PATH      = 'neighborhoods';
    const SMALL     = '400*300*75';
    const EXTENSION = 'webp';
    const HASH_NAME = true;

    // Show All Rows
    public function index()
    {

        // Search Attr
        $qCity = request('city');
        $qName = request('name');

        $rows = Neighborhood::with(['by', 'city'])->orderByDesc('id')->paginate(25);

        // ->where('city_id',  request('city'))->where('name', 'like', '%' . request('name') . '%')
        // $sqlQuery = $qCity != null ? $sqlQuery->where('city_id', request('city')) : $sqlQuery;
        // $sqlQuery = $qName != null ? $sqlQuery->where('name', 'like', '%' . request('name') . '%') : $sqlQuery;

        $cities = City::orderByDesc('id')->get()->toArray();

        // Check IF Have Edit
        $id = intval(request('edit'));

        if ($id != 0) {

            $editRow = Neighborhood::where('id', $id)->first();

            // Form Update Options
            $formOption = [
                'panelTitle'   => 'تحديث بيانات حي',
                'submitButton' => 'تحديث',
                'formAction'   => route('neighborhoods-update'),
            ];

            if ($editRow == null) {
                return redirect(adminUrl('neighborhoods'))->with('warning', 'البيانات المطلوبة غير متاحة في النظام');
            }

        } else {

            // Form Create Options
            $editRow    = [];
            $formOption = [
                'panelTitle'   => 'اضافة حي جديد',
                'submitButton' => 'اضافة',
                'formAction'   => route('neighborhoods-store'),
            ];
        }

        return view('dashboard.neighborhoods.index', compact('rows', 'cities', 'editRow', 'formOption'));
    }

    // Insert New Row
    public function store(Request $request, Neighborhood $neighborhoods)
    {

        // Prepare Input Validation
        $this->validateAttr = array_merge([
            'city_id' => 'required|exists:cities,id',
            'image'   => 'nullable|max:3072|mimes:' . mimesType('image_accept_resize'),
        ], collect(languages())->flatMap(fn($val, $key) => [
            "{$key}.name"                                   => "required|string|max:150|min:2|unique:neighborhood_translations,name,NULL,id,locale,{$key}",
        ])->toArray());

        // Validate
        $data = $request->validate($this->validateAttr);

        // Upload Image
        $data['image'] = FileUploader::upload('image', [
            'path'      => self::PATH,
            'extension' => self::EXTENSION,
            'hash'      => self::HASH_NAME,
            'small'     => self::SMALL,
            'max_width' => 1000,
            'quality'   => 70,
        ]);

        // Add New Attr
        $data['created_by'] = adminId();

        // Insert
        $neighborhoods->create($data);

        return Response::success('تم اضافة الحي بنجاح...', ['style' => 'toastr', 'reset' => true, 'reload' => true, 'time_out' => 2]);
    }

    // Update Row
    public function update(Request $request)
    {

        $row = Neighborhood::where('id', $request->id)->first();

        // Check If Not Exists in db
        if ($row == null) {
            return Response::error('البيانات المطلوبة غير متوفرة في النظام', ['style' => 'toastr']);
        }

        // Prepare Input Validation
        $this->validateAttr = array_merge([
            'city_id' => 'required|in:' . inValidateByPluck(City::get()->pluck('id')),
            'image'   => 'nullable|max:3072|mimes:' . mimesType('image_accept_resize'),
        ], collect(languages())->flatMap(function ($val, $key) use ($row) {
            return [
                "$key*.name" => 'required|max:150|min:2|unique:neighborhoods_translations,name,' . ($row->id ?? 'NULL') . ',neighborhood_id,locale,' . $key,
            ];
        }
        )->toArray());

        $data = $request->validate($this->validateAttr);

        // Upload Image
        $data['image'] = FileUploader::upload('image', [
            'path'      => self::PATH,
            'extension' => self::EXTENSION,
            'hash'      => self::HASH_NAME,
            'small'     => self::SMALL,
            'max_width' => 1000,
            'quality'   => 70,
            'delete'    => $row->image,
        ]);

        // Insert
        $row->update($data);

        // Return Message
        return Response::success('تم تحديث الحي بنجاح...', ['style' => 'toastr', 'redirect' => adminUrl('neighborhoods'), 'reload' => true, 'time_out' => 2]);
    }

    // Delete Row
    public function destroy()
    {
        // Get Row And Check IF IN Database
        $row = Neighborhood::find(request('id'));

        // Check If Not Exist The Row IN Database
        if (empty($row)) {
            // Message
            return Response::error('هذه العملية غير مصرح بها، وقد لا تكون البيانات المطلوبة متاحة في النظام', ['style' => 'toastr']);
        } else {
            // Delete Image From Storage
            if ($row->image != null) {
                FileUploader::delete(self::PATH, $row->image);
            }

            // Delete From DB
            $row->delete();
            //Message
            return Response::success('تم حذف البيانات بنجاح', ['style' => 'toastr']);
        }
    }

    public function getNeighborhoodsByCity()
    {

        $cityId = request('city_id');

        $neighborhoods = Neighborhood::where('city_id', $cityId)->select('id')->get();

        if ($neighborhoods->isEmpty()) {
            return response()->json([
                'status'  => 'empty',
                'message' => 'لا يوجد أحياء مرتبطة بهذه المدينة حتى الآن !',
            ]);
        }

        return response()->json($neighborhoods);
    }

}
