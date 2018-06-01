<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'Administer roles & permissions']);
        Permission::create(['name' => 'approve videos']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['Administer roles & permissions', 'approve videos']);
    }
}
