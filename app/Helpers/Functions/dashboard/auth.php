<?php

/*
|--------------------------------------------------------------------------
| File Map
|--------------------------------------------------------------------------
|
| - adminGuardName()   → Returns the guard name used for admin authentication
| - adminAuth()        → Get authenticated admin attribute
| - admin()            → Get authenticated admin model
| - adminId()          → Get authenticated admin ID
| - canPermission()    → Check if admin has specific permission
| - canRole()          → Check if admin has specific role
| - owner()            → Return owner role name
|
*/

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Support\Facades\Auth;

if (! function_exists('adminGuardName')) {
    /**
     * Get admin guard name
     *
     * @return string
     */
    function adminGuardName()
    {
        return 'admin';
    }
}

if (! function_exists('adminAuth')) {
    /**
     * Get authenticated admin attribute dynamically
     *
     * @param string $get
     * @return mixed|null
     */
    function adminAuth($get)
    {
        if (Auth::guard(adminGuardName())->check()) {
            return auth(adminGuardName())->user()->$get;
        }

        return null;
    }
}

if (! function_exists('isSalesAdmin')) {
    /**
     * Get boolif admin type salse
     *
     * @return bool
     */
    function isSalesAdmin(): bool
    {
        return adminAuth('type') === 'sales';
    }
}

if (! function_exists('admin')) {
    /**
     * Get authenticated admin model
     *
     * @return Admin|null
     */
    function admin(): ?Admin
    {
        return auth(adminGuardName())->user();
    }
}

if (! function_exists('adminId')) {
    /**
     * Get authenticated admin ID
     *
     * @return int|null
     */
    function adminId()
    {
        return adminAuth('id');
    }
}

if (! function_exists('canPermission')) {
    /**
     * Check if admin has a specific permission
     *
     * @param string $permission
     * @return bool
     */
    function canPermission(string $permission)
    {
        return auth(adminGuardName())->user()?->can($permission) ?? false;
    }
}

if (! function_exists('canRole')) {
    /**
     * Check if admin has a specific role
     *
     * @param string $role
     * @return bool
     */
    function canRole(string $role)
    {
        return auth(adminGuardName())->user()?->hasRole($role) ?? false;
    }
}

if (! function_exists('owner')) {
    /**
     * Get owner role key
     *
     * @return string
     */
    function owner()
    {
        return 'owner';
    }
}
