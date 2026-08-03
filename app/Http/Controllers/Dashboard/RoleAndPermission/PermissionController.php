<?php
namespace App\Http\Controllers\Dashboard\RoleAndPermission;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:' . owner()], ['only' => ['index', 'update']]);
    }

    private function permissionQuery($group_name)
    {
        return Permission::where('group_name', $group_name)->get(['id', 'name', 'display_name']);
    }

    public function index($id)
    {

        $row = Role::find($id);

        if (empty($row)) {
            return redirect(adminUrl('roles'));
        }

        // IDs of permissions already assigned to that role
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_id", $id)
            ->pluck('permission_id')
            ->all();

        // build data with IDs + label
        $data = [
            [
                'name'        => 'المستخدمين',
                'permissions' => $this->permissionQuery('admin'),
            ],
            [
                'name'        => 'العملاء',
                'permissions' => $this->permissionQuery('clients'),
            ],
            [
                'name'        => 'اهتمامات العملاء',
                'permissions' => $this->permissionQuery('interests'),
            ],
            [
                'name'        => 'الصفقات',
                'permissions' => $this->permissionQuery('deals'),
            ],
            [
                'name'        => 'اتحادات الملاك',
                'permissions' => $this->permissionQuery('owner_associations'),
            ],
            [
                'name'        => 'الوحدات & العقارات',
                'permissions' => $this->permissionQuery('properties'),
            ],
            [
                'name'        => 'المدن',
                'permissions' => $this->permissionQuery('city'),
            ],
            [
                'name'        => 'المناطق',
                'permissions' => $this->permissionQuery('neighborhood'),
            ],
            [
                'name'        => 'مستويات التشطيب',
                'permissions' => $this->permissionQuery('property_furnishing'),
            ],
            [
                'name'        => 'مميزات  الوحدات',
                'permissions' => $this->permissionQuery('property_features'),
            ],
            [
                'name'        => 'مرافق الوحدات',
                'permissions' => $this->permissionQuery('property_amenities'),
            ],
            [
                'name'        => 'أنواع العقارات',
                'permissions' => $this->permissionQuery('property_types'),
            ],
            [
                'name'        => 'واجهات العقارات',
                'permissions' => $this->permissionQuery('property_facades'),
            ],

            //////////////////////
            //////////////////////
            //////////////////////
            //////////////////////
            //////////////////////
            //
            // [
            //     'name'        => 'الحالات & الأغراض',
            //     'permissions' => $this->permissionQuery('property_status'),
            // ],
            // [
            //     'name'        => 'إعدادات الموقع',
            //     'permissions' => $this->permissionQuery('website_setting'),
            // ],

        ];

        return view('dashboard.role-and-permission.permission', compact('row', 'data', 'rolePermissions'));
    }

    // public function index($id, RoleController $roleController)
    // {

    //     $data = [
    //         [
    //             'name'        => 'المستخدمين',
    //             'permissions' => getPermissions('admin'),
    //         ],
    //         [
    //             'name'        => 'العقارات',
    //             'permissions' => getPermissions('properties'),
    //         ],
    //     ];

    //     $roleController->checkOwner($id);

    //     $row = Role::find($id);

    //     if (empty($row)) {
    //         // Get Row For Edit
    //         return redirect(adminUrl('roles'));
    //     }

    //     $rolePermissions = DB::table("role_has_permissions")
    //         ->where("role_id", $id)
    //         ->pluck('permission_id')
    //         ->all();

    //         dd( $rolePermissions);

    //     return view('dashboard.role-and-permission.permission', compact('row', 'data', 'rolePermissions'));

    // }

    public function update(Request $request, RoleController $roleController)
    {
        $roleId = $request->id;

        $roleController->checkOwner($roleId);

        $role = Role::find($roleId);

        if (! empty($role)) {

            $permissions = $request->permission;
            // Delete Old
            DB::table('role_has_permissions')->where('role_id', $roleId)->delete();
            if ($permissions != null) {
                foreach ($permissions as $row) {
                    $role->givePermissionTo($row); // Set This Permisson For The Role
                }
            } else {
                $role->givePermissionTo(); // Set This Permisson For The Role
            }

        }
        return Response::success('تم تحديث الأذونات بنجاح', ['style' => 'toastr']);

    }

}
