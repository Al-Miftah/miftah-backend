<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Setup
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(['RolesAndPermissionsSeeder']);
        $admin = factory('App\Models\User')->create();
        $admin->givePermissionTo('Update user permissions');
        $this->authenticate($admin);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_permissions()
    {
        $response = $this->getJson(route('permissions.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name']
            ]
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authorized_admin_can_updates_user_permissions_list()
    {
        
        $user = factory('App\Models\User')->create();
        $permission = Permission::firstWhere('name', 'Create Speaker');
        //Assert user has no permission
        $this->assertFalse($user->can('Create Topic'));
        $params = [
            'permissions' => [$permission->name]
        ];
        $response = $this->patchJson(route('user.permissions.update', $user), $params);
        $response->assertOk();
        //User has permission for both web and api guards
        $this->assertTrue($user->fresh()->can('Create Speaker'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_roles_in_the_system()
    {
        $response = $this->getJson(route('roles.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name']
            ]
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authorized_admin_can_update_user_roles_list()
    {
        $user = factory('App\Models\User')->create();
        //Assert user has no role named 'Admin'
        $this->assertFalse($user->hasRole('Admin'));
        $role = Role::firstWhere('name', 'Admin');
        $params = [
            'roles' => [$role->name]
        ];
        $response = $this->patchJson(route('user.roles.update', $user), $params);
        $response->assertOk();
        //Assert user now has role 'Admin'
        $this->assertTrue($user->fresh()->hasRole($role));
    }
}
