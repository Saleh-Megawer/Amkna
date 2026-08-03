<?php
namespace App\Helpers;

use Spatie\Permission\Models\Role;

class RoleHelper
{
    const PROTECTED_VIEW_ROLES = ['owner'];
    const IMMUTABLE_ROLES      = ['owner', 'sales', 'admin'];

    public static function get()
    {
        return new Role;
    }

    // public static function hideOwner()
    // {
    //     return Role::whereNotIn('name', ['owner'])->orderByDesc('id');
    // }

    public static function getAvailableRoles()
    {
        return Role::whereNotIn('name', self::PROTECTED_VIEW_ROLES)
            ->orderByDesc('id');
    }

    public static function isProtected($roleName)
    {
        return in_array($roleName, self::IMMUTABLE_ROLES);
    }
}
