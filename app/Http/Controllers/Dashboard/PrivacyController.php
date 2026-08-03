<?php
namespace App\Http\Controllers\Dashboard;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Privacy\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{

    private $validateAttr = [];

    public function index()
    {
        // Check If Have Row
        $row = Privacy::first();
        return view('dashboard.privacy', compact('row'));
    }

    public function storeUpdate(Request $request)
    {

        /**
         *  Input Validate
         *  Input Set Validate By Languages
         */
        foreach (languages() as $key => $val) {
            $this->validateAttr[$key . '*.desc'] = 'required';
        }

        /**
         * Validate
         */
        $request->validate($this->validateAttr);

        $data = $request->except('_token', '_method', 'files'); // Unset Token In Request

        // Check If Have Row
        $row = Privacy::first();

        if ($row != null) {
            $row->update($data);
            return Response::success('تم تحديث سياسة الخصوصية  بنجاح', ['style' => 'toastr']);
        } else {

            Privacy::create($data);
            return Response::success('تم اضافة سياسة الخصوصية بنجاح', ['style' => 'toastr']);
        }
    }
}
