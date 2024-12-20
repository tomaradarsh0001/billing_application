<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'configuration.view']);
        Permission::create(['name' => 'configuration.create']);
        Permission::create(['name' => 'configuration.edit']);
        Permission::create(['name' => 'configuration.delete']);
        Permission::create(['name' => 'users.view']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'superadmin']);
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Superadmin gets all permissions
        $superAdmin->givePermissionTo(Permission::all());

        // Admin gets specific permissions
        $admin->givePermissionTo(['configuration.view', 'configuration.edit']);

        // User gets limited permissions
        $user->givePermissionTo('configuration.view');
    }
}
