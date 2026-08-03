<?php
namespace App\Http\Controllers\Dashboard\Admin;

use App\Helpers\File;
use App\Helpers\Response;
use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use App\Mail\MarketerApprovedMail;
use App\Mail\MarketerRejectedMail;
use App\Models\Dashboard\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    use AdminHelpers;

    public function __construct()
    {
        $this->middleware(['permission:admins'], ['only' => 'index']);
        $this->middleware(['permission:create_admin'], ['only' => ['store', 'create']]);
        $this->middleware(['permission:activate_deactivate_admin'], ['only' => ['activeAccount', 'closedAccount']]);
        $this->middleware(['role:' . owner()], ['only' => 'destroy']);
    }

    // Admins Page
    public function index()
    {

        $admins = Admin::with('roles')->where('id', '!=', 1)->orderByDesc('id')->get(); // eager load roles

        $roles = RoleHelper::getAvailableRoles()->get();

        return view('dashboard.admin.all', [
            'roles'      => $roles,
            'admins'     => $admins,
            'coverPath'  => $this->coverPath,
            'avatarPath' => $this->avatarPath,
        ]);
    }

    public function create()
    {

        $roles = RoleHelper::getAvailableRoles()->get();
        return view('dashboard.admin.create', compact('roles'));
    }

    // public function store(Request $request)
    // {

    //     // Validate Row
    //     $data = $request->validate([
    //         'f_name'   => 'required|max:20|min:2',
    //         'l_name'   => 'required|max:20|min:2',
    //         'email'    => 'required|email|max:255|unique:' . $this->table() . ',email',
    //         'password' => 'required|min:8|max:255',
    //     ]);

    //     // Change To HeadLine Text Format
    //     $data['f_name'] = Str::headline($request->f_name);
    //     $data['l_name'] = Str::headline($request->l_name);

    //     // Set Full Name
    //     $data['full_name'] = $data['f_name'] . ' ' . $data['l_name'];

    //     // Password Hash
    //     $data['password'] = Hash::make($data['password']);

    //     // Create
    //     $insert = $this->model()->create($data);

    //     //        @if (canRole(owner()) || $role->name != owner())

    //     if ($request->roles && is_array($request->roles)) {

    //         $roles = array_filter($request->roles, function ($role) {
    //             if (canRole(owner()) || $role != owner()) {
    //                 return $role;
    //             }
    //         });
    //         $insert->assignRole($roles);
    //     }

    //     $this->createAdminTables($insert->id);

    //     return Response::success('تم إضافة المستخدم بنجاح', ['style' => 'toastr', 'reset' => true]);
    // }

    public function store(Request $request)
    {
        // Validate Row
        $data = $request->validate([
            'f_name'   => 'required|max:20|min:2',
            'l_name'   => 'required|max:20|min:2',
            'email'    => 'required|email|max:255|unique:' . $this->table() . ',email',
            'password' => 'required|min:8|max:255',
            'type'     => 'required|in:sales,admin',
        ]);

        // Change To HeadLine Text Format
        $data['f_name'] = Str::headline($request->f_name);
        $data['l_name'] = Str::headline($request->l_name);

        // Set Full Name
        $data['full_name'] = $data['f_name'] . ' ' . $data['l_name'];

        $data['is_available'] = false;

        // Password Hash
        $data['password'] = Hash::make($data['password']);

        // Create
        $insert = $this->model()->create($data);

        // تعيين الأدوار حسب النوع
        if ($request->type === 'sales') {
            // لو مبيعات، حدد دور sales فقط
            $insert->assignRole('sales');
        } else {
            // لو مشرف عام، استخدم الأدوار المختارة
            if ($request->roles && is_array($request->roles)) {
                $roles = array_filter($request->roles, function ($role) {
                    if (canRole(owner()) || $role != owner()) {
                        return $role;
                    }
                });
                $insert->assignRole($roles);
            }
        }

        $this->createAdminTables($insert->id);

        return Response::success('تم إضافة المستخدم بنجاح', ['style' => 'toastr', 'reset' => true]);
    }

    // Edit View
    public function edit($id)
    {
        return view('dashboard.admin.profile.edit');
    }

    public function changeAdminPassword(Request $request)
    {
        $id = $this->getAdminIdFromRequest();

        if ($id != adminId()) {

            $request->validate([
                'password' => 'required|min:8|max:255',
            ]);

            $update = $this->model()->where('id', $id)->update([
                'password' => Hash::make($request->password),
            ]);

            if ($update > 0) {
                return Response::success('تم تحديث كلمة المرور بنجاح', ['style' => 'toastr']);
            }

        } else {
            return Response::warning('هذه العملية غير مصرح بها', ['style' => 'toastr']);
        }

    }

    public function activeAccount(string $status = '1')
    {
        $adminId = request('id');

        if ($adminId == '1') {
            return abort(404);
        }
        // Check IF Admin Exist IN DB
        $row = $this->model()->where('id', $adminId)->count();

        if ($row > 0) {

            $this->model()->where('id', $adminId)->update([
                'status' => $status,
            ]);

            return response([
                'account_status' => $status,
                'closed'         => 'Closed',
                'activate'       => 'Activate',
                'deactivate'     => 'DeActivate',
            ]);
        } else {
            return abort(404);
        }
    }

    public function closedAccount()
    {
        return $this->activeAccount('0');
    }

    // Search
    public function search(Request $request, Admin $admin)
    {
        $q    = $request->name;
        $rows = DB::table($admin->table)->where('id', '!=', 1)->where('full_name', 'like', "%$q%")->get(['full_name', 'email', 'id', 'phone']);
        return response($rows);
    }

    public function destroy()
    {
        $adminId = $this->getAdminIdFromRequest();

        // Check IF Exist
        $row = $this->model()->where('id', '!=', 1)->where('id', $adminId)->select(['avatar', 'cover'])->first();

        if (! empty($row)) {

            // Delete Attech
            File::delete($this->avatarPath, $row->avatar);
            File::delete($this->avatarPath, $row->cover);

            // Delete From DB
            $this->model()->where('id', $adminId)->delete();
        }

        // Redirect
        return redirect(adminUrl('admins'));
    }

    //////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////

    // public function approve(Request $request)
    // {
    //     $user = Admin::findOrFail($request->id);

    //     $password = Str::password(12, true, true, true);

    //     // تجربة إرسال الإيميل فقط بدون تعديل DB
    //     Mail::to($user->email)
    //         ->send(new MarketerApprovedMail($user, $password));

    //     return Response::success('تم إرسال رسالة القبول للتجربة فقط');
    // }

    public function approve(Request $request)
    {

        $user = Admin::findOrFail($request->id);

        $password = Str::password(12, true, true, true);

        $user->update([
            'status'              => 1,
            'is_marketer_request' => false,
            'password'            => Hash::make($password),
        ]);

        Mail::to($user->email)
            ->send(new MarketerApprovedMail($user, $password));

        return Response::success('تم قبول طلب المسوق وإرسال إشعار له', [
            'style'    => 'toastr',
            'time_out' => 3,
            'redirect' => adminUrl('admins'),
        ]);

    }

    public function reject(Request $request)
    {

        $request->validate([
            'id'      => 'required|exists:admins,id',
            'message' => 'nullable|string|max:1000',
        ]);

        $user = Admin::findOrFail($request->id);

        // إرسال الإيميل
        Mail::to($user->email)->send(
            new MarketerRejectedMail($user, $request->message)
        );

        // حذف الطلب
        $user->delete();

        return Response::warning('تم رفض طلب المسوق وإرسال إشعار له', [
            'style'    => 'toastr',
            'time_out' => 3,
            'redirect' => adminUrl('admins'),
        ]);

    }

}
