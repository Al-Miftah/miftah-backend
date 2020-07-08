<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Roles
        $roles = [
            [
                'name' => 'Super Admin',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Admin',
                'guards' => ['api', 'web']
            ],
        ];

        //Permissions
        $permissions = [
            [
                'name' => 'Update user permissions',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Create Speaker',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Update Speaker',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Delete Speaker',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Force delete Speaker',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Create Topic',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Update Topic',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Delete Topic',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Create Speech',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Update Speech',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Delete Speech',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Force delete Speech',
                'guards' => ['api', 'web']
            ],
            [
                'name' => 'Create Tag',
                'guards' => ['api', 'web']
            ]
        ];

        //Create roles
        foreach ($roles as $role) {
            foreach ($role['guards'] as $guard) {
                Role::firstOrCreate([
                    'name' => $role['name'],
                    'guard_name' => $guard
                ], []);
            }
        }

        //Create permissions
        foreach ($permissions as $permission) {
            foreach ($permission['guards'] as $guard) {
                Permission::firstOrCreate([
                    'name' => $permission['name'],
                    'guard_name' => $guard
                ], []);
            }
        }
    }
}
