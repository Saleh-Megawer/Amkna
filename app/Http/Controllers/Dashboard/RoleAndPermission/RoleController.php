<?php
namespace App\Http\Controllers\Dashboard\RoleAndPermission;

use App\Helpers\Response;
use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:' . owner()], ['only' => ['index', 'store', 'update', 'destroy']]);
    }

    // Check IF Role " Owner "
    public function checkOwner($id, $abort = true)
    {
        $row = Role::find($id);
        if (! empty($row)) {
            if ($row->name == 'owner' && $row->id == 1) {
                if ($abort === true) {
                    return abort(403, 'This operation cannot be performed');
                } else {
                    die();
                }
            }
        }
    }

    public function index()
    {
        $id      = request('id');
        $rowEdit = null;

        // Form Store
        $actionUrl = route('store-role');
        $btnText   = 'اضافة الدور';
        $nameVal   = null;

        if (! empty($id)) {
            // Get Row For Edit
            $rowEdit = Role::find($id);

            if (RoleHelper::isProtected($rowEdit->name)) {
                Response::warning('لا يمكن تعديل الدور المطلوب', ['json' => false]);
                return redirect(adminUrl('roles'));
            }
            if (! empty($rowEdit)) {
                // Form Update If Have Edit Row
                $actionUrl = route('update-role');
                $btnText   = 'تحديث الدور';
                $nameVal   = $rowEdit->name;
            }
        }

        $roles = RoleHelper::getAvailableRoles()->withCount('permissions') // إضافة عدد الصلاحيات
            ->orderByDesc('id')
            ->get();

        // إجمالي عدد الصلاحيات في النظام
        $totalPermissions = \Spatie\Permission\Models\Permission::count();

        $protected_roles = RoleHelper::IMMUTABLE_ROLES;

        return view('dashboard.role-and-permission.role', compact('roles', 'nameVal', 'actionUrl', 'btnText', 'protected_roles', 'totalPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => strtolower($request->name),
        ]);

        Response::success('Role Added Successfully', ['json' => false]);
        return back();
    }

    public function update(Request $request)
    {
        $id  = $request->id;
        $row = Role::find($id);
        $this->checkOwner($id);

        if (! empty($row)) {

            $request->validate([
                'name' => 'required|max:255|unique:roles,name,' . $id,
            ]);

            if (RoleHelper::isProtected($row->name)) {
                Response::warning('لا يمكن تعديل الدور المطلوب', ['json' => false]);
                return redirect(adminUrl('roles'));
            }

            $row->name = strtolower($request->name);
            $row->save();
            Response::success('Role Updated Successfully', ['json' => false]);
        }

        return redirect(adminUrl('roles'));
    }

    // public function destroy(Request $request)
    // {
    //     $id = $request->id;

    //     try {

    //         // Decrypt ID Value
    //         $id = Crypt::decryptString($id);

    //         $this->checkOwner($id);

    //         // Get Row And Check IF IN Database
    //         $row = Role::find($id);

    //         // Check If Not Exist The Row IN Database
    //         if (empty($row)) {
    //             // Message
    //             $request->session()->flash('error', dbTrans('global.This operation is not authorized, the requested data may not be available in the system'));
    //         } else {
    //             // Delete From DB
    //             $row->delete();

    //             // Message
    //             $request->session()->flash('success', dbTrans('global.The data has been deleted successfully'));
    //         }
    //     } catch (DecryptException $e) {
    //         // Message
    //         $request->session()->flash('warning', dbTrans('global.Warning An error occurred while performing this operation, try again'));
    //     }
    //     return back();
    // }

    protected function isProtectedRole($roleName)
    {
        return in_array($roleName, ['owner', 'sales']);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        try {
            // Decrypt ID Value
            $id = Crypt::decryptString($id);

            $this->checkOwner($id);

            // Get Row And Check IF IN Database
            $row = Role::find($id);

            // Check If Not Exist The Row IN Database
            if (empty($row)) {
                $request->session()->flash('error', 'هذه العملية غير مصرح بها، البيانات المطلوبة قد لا تكون متاحة في النظام');
            }
            // تحقق من الأدوار المحمية
            elseif ($this->isProtectedRole($row->name)) {
                $request->session()->flash('error', 'لا يمكن حذف هذا الدور، إنه محمي من الحذف');
            } else {
                // Delete From DB
                $row->delete();

                $request->session()->flash('success', 'تم حذف البيانات بنجاح');
            }
        } catch (DecryptException $e) {
            $request->session()->flash('warning', 'تحذير: حدث خطأ أثناء تنفيذ هذه العملية، حاول مرة أخرى');
        }

        return back();
    }

}
