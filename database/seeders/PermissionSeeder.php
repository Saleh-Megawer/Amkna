<?php
namespace Database\Seeders;

use App\Models\Dashboard\Admin\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //if (Permission::count() == 0) {

        $admin = $this->setRoleAndPermisson('admin');

        foreach (config('roles-and-permissions') as $sectionKey => $permissions) {
            if (! in_array($sectionKey, ['owner', 'admin', 'sales'], true)) {
                $this->setRoleAndPermisson($sectionKey, false);
            }
        }

        /*
        |
        | Make Role "owner" In System
        |
        */
        $owner = Role::create(['name' => 'owner', 'guard_name' => adminGuardName()]);

        // Create Default Owner
        $userOwner = Admin::create([
            'f_name'    => "System",
            'l_name'    => "Backup",
            'full_name' => 'System Backup',
            'email'     => 'system@gmail.com',
            'password'  => bcrypt('System@2020'),
        ]);
        $userOwner->assignRole($owner);

        // Create Default Owner
        $userAdmin = Admin::create([
            'f_name'    => "Admin",
            'l_name'    => "User",
            'full_name' => 'Admin User',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('123'),
        ]);
        $userAdmin->assignRole($owner);

        $sales = Role::firstOrCreate([
            'name'       => 'sales',
            'guard_name' => adminGuardName(),
        ]);

        // Create Default Owner
        $mohamedSales = Admin::create([
            'f_name'       => "محمد",
            'l_name'       => "عبدالرحمن",
            'full_name'    => 'محمد عبدالرحمن',
            'email'        => 'mohamed@gmail.com',
            'password'     => bcrypt('123'),
            'type'         => 'sales',
            'is_available' => true,
        ]);
        $mohamedSales->assignRole($sales);

        for ($i = 1; $i < 2; $i++) {
            // Create Default Owner
            $userSales = Admin::create([
                'f_name'       => "Sales",
                'l_name'       => "Man ( " . $i . " )",
                'full_name'    => 'Sales Man ( ' . $i . ' )',
                'email'        => 'sales' . $i . '@gmail.com',
                'password'     => bcrypt('123'),
                'type'         => 'sales',
                'is_available' => true,
            ]);
            $userSales->assignRole($sales);
        }

    }

    public function setRoleAndPermisson($roleKey, $create_role = true)
    {

        if ($create_role) {
            $role = Role::create(['name' => $roleKey, 'guard_name' => adminGuardName()]); // Create Rol
        }
        $permissions = getPermissions($roleKey);

        foreach ($permissions as $perm => $val) {

            Permission::create([
                'group_name'   => $roleKey,
                'name'         => $perm,
                'display_name' => $val,
                'guard_name'   => adminGuardName(),
            ]);

            // Create Permissions
            if ($create_role) {
                $role->givePermissionTo($perm);
                // Set This Permisson For The Role
            }

        }

        if ($create_role) {

            return $role;
        }

    }

}
