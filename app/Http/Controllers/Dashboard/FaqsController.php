<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faqs\Faqs;

class FaqsController extends Controller
{

    private $validateAttr = [];

    public function index()
    {
        $rows = Faqs::get();

        return view('dashboard.faqs.index', compact('rows'));
    }

    public function create()
    {

        return view('dashboard.faqs.create');
    }

    public function store(Request $request)
    {

        /**
         *  Input Validate
         *  Input Set Validate By Languages
         */
        foreach (languages() as $key => $val) {
            $this->validateAttr[$key . '*.title'] = 'required|string|max:255';
            $this->validateAttr[$key . '*.desc'] = 'required|string';
        }

        /**
         * Validate
         */
        $request->validate($this->validateAttr);


        // Unset & Prepare Data From Request
        $data = $request->except('_token'); // Unset Token In Request

        /**
         * Insert
         */
        Faqs::create($data);

        return Response::success('تم اضافة السؤال بنجاح', ['style' => 'toastr', 'reset' => true]);

    }

    public function edit($id)
    {
        $row =  Faqs::where('id', $id)->first();
        return view('dashboard.faqs.edit', compact('row'));
    }

    public function update(Request $request)
    {

        $id = $request->id;

        $row = Faqs::where('id', $id)->first();

        if ($row == null) {
            return Response::error('لا يمكن تنفيذ هذا الإجراء، فهذه البيانات غير متوفرة في النظام', ['style' => 'toastr']);
        }

        /**
         *  Input Validate
         *  Input Set Validate By Languages
         */

        foreach (languages() as $key => $val) {
            $this->validateAttr[$key . '*.title'] = 'required|string|max:255';
            $this->validateAttr[$key . '*.desc'] = 'required|string';
        }

        /**
         * Validate
         */
        $request->validate($this->validateAttr);

        // Unset & Prepare Data From Request
        $data = $request->except('_token', '_method','files'); // Unset Token In Request

        /**
         * Insert
         */
        $row->update($data);


        return Response::success('تم تحديث البيانات بنجاح', ['style' => 'toastr']);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        // Get Row And Check IF IN Database
        $row = Faqs::find($id);

        // Check If Not Exist The Row IN Database
        if (empty($row)) {
            // Message
            return Response::error('لا يمكن تنفيذ هذا الإجراء، فهذه البيانات غير متوفرة في النظام', ['style' => 'toastr']);
        } else {
            // Delete From DB
            $row->delete();
            // Message
            return Response::success("تم حذف السؤال بنجاح", ['style' => 'toastr']);
        }
    }
}
