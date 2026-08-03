<?php

namespace App\Http\Controllers\Dashboard\Admin;

use Illuminate\Support\Facades\DB;
use App\Models\Dashboard\Admin\Admin;
use Illuminate\Support\Facades\Crypt;
use App\Models\Dashboard\Admin\AdminPortfolio;
use App\Models\Dashboard\Admin\AdminAttributes;
use Illuminate\Contracts\Encryption\DecryptException;

trait AdminHelpers
{

    public $avatarPath = 'avatars';
    public $coverPath = 'covers';
    public $hash = true; // Second Path For Public Use
    public $extension = 'webp'; // Second Path For Public Use


    public $modelType = 'App\Models\Dashboard\Admin\Admin';

    public function model()
    {
        return new Admin;
    }

    public function table()
    {
        return $this->model()->table;
    }


    /**
     * This Method Will Be Check Admin Others Table Created Or No
     * @param int $admin_id IF Not Set Value By Defualt Get Admin Auth Id
     */
    public function createAdminTables(int $admin_id = 0)
    {
        $admin_id == 0 ? adminId() : $admin_id;

        // Admin Attr
        $staticWhere = ['admin_id' => $admin_id]; // Where

        $adminAttr = AdminAttributes::where($staticWhere)->count();
        if ($adminAttr == 0) {
            // Create New Row And Set admin_id = Auth Id
            AdminAttributes::create($staticWhere);
        }

        // Admin Port
        $adminPort = AdminPortfolio::where($staticWhere)->count();
        if ($adminPort == 0) {
            // Create New Row And Set admin_id = Auth Id
            AdminPortfolio::create($staticWhere);
        }
    }


    // Helpers Method Get Years
    private function yearsList($startYear = 1995, $endYear = null)
    {
        // Check IF End Year Null Set date('Y)
        $endYear = $endYear == null ? date('Y') : $endYear;

        // Array For Push All Year Here
        $yearsList = [];

        // Loop
        for ($i = $startYear; $i <= $endYear; $i++) {
            // Push Years To Array
            array_push($yearsList, $i);
        }

        // Return Years Array
        return $yearsList;
    }

    // Get Admin Profile Avatar
    public function avatar($avatarName = null)
    {
        $avatarName == null ? adminAuth('cover') : $avatarName;

        // Check IF Exist This Image In Storage
        if (file_exists(smallPath($this->avatarPath . '/' . $avatarName)) && $avatarName != null) {
            return smallAsset($this->avatarPath  . '/' . $avatarName);
        } else {
            return asset('dashboard/images/admin/default-avatar.png');
        }
    }

    // Get Admin Profile cover
    public function cover($coverName = null)
    {
        $coverName == null ? adminAuth('cover') : $coverName;
        // Check IF Exist This Image In Storage
        if (file_exists(largePath($this->coverPath . '/' . $coverName)) && $coverName != null) {
            return largeAsset($this->coverPath  . '/' . $coverName);
        } else {
            return asset('dashboard/images/admin/covers/large/' . rand(1, 7) . '.jpg');
        }
    }



    /**
     * In Update Admin Data Or Update Profile Data This Method Will Be Check IF
     * This Admin Can Update This Data Or No And Return Id If Have Permission
     */
    public function getAdminIdFromRequest()
    {
        try {

            $id = Crypt::decryptString(request('id'));

            // Check IF ID Equal Auth Admin ID
            if (intval($id) === adminId()) {
                return adminId();
            } else {
                // Check Permissions
                if (canRole('owner')) {
                    return $id;
                } else {
                    return abort(403);
                }
            }
        } catch (DecryptException $e) {
            return abort(403, 'This identifier does not exist');
        }
    }



    /**
     *
     *  Admin Attributes
     *
     */
    // Check IF Admin Have Row In Table admin_attributes
    public function adminAttr($admin_id, array $select = ['*'], array $where = [])
    {
        return AdminAttributes::where(['admin_id' => $admin_id])->where($where)->first($select);
    }


    // Select Password Attr
    public function passwordAttr(array $where)
    {
        return $this->adminAttr(adminId(), ['forget_password_expiry_date', 'forgot_password_token'], $where);
    }


    public function adminRoles($id)
    {
        return DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select(['name'])
            ->where(['model_id' => $id, 'model_type' => $this->modelType])
            ->pluck('name')->all();
    }
}
