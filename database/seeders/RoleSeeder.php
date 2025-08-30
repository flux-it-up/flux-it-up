<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $config = config('roles');

        // Create all permissions first
        foreach ($config['permissions'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles & assign permissions
        foreach ($config['roles'] as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            if ($permissions === '*') {
                // Give all permissions to this role
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($permissions);
            }
        }
    }
}
