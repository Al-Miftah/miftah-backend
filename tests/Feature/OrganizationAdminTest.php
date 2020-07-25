<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class OrganizationAdminTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $admin = $this->authenticate();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_admins_of_an_organization()
    {
        $organization = factory(Organization::class)->create();
        $users = factory('App\Models\User', 2)->create();
        $organization->admins()->attach($users->pluck('id'));
        $response = $this->getJson(route('organization.admin.index', $organization));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'membership']
            ]
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_grants_a_an_admin_access_to_an_organization()
    {
        $user = factory('App\Models\User')->create();
        $organization = factory(Organization::class)->create();
        $params = [
            'users' => [$user->id]
        ];
        $response = $this->postJson(route('organization.admin.store', $organization), $params);
        $response->assertOk();
        $this->assertTrue($organization->admins->contains($user));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_revokes_organization_admin_access_from_a_user()
    {
        $user = factory('App\Models\User')->create([
            'name' => 'John Doe'
        ]);
        $organization = factory(Organization::class)->create();
        $organization->admins()->attach($user->id);
        //Assert user is granted admin level
        $this->assertTrue($organization->admins->contains($user));
        $params = [
            'users' => [$user->id]
        ];
        $response = $this->deleteJson(route('organization.admin.destroy', $organization), $params);
        $response->assertNoContent(204);
        $this->assertFalse($organization->fresh()->admins->contains($user));
       
    }
}
