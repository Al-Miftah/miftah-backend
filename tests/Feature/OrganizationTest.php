<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class OrganizationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Setup
     *
     * @return void
     */
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
    public function an_authorized_user_can_create_an_organization()
    {
        $params = [
            'name' => 'Wa central mosque',
            'digital_address' => 'XW-0006-0904',
            'phone_number' => '+233240000000',
            'about' => $this->faker->sentence,
        ];
        $response = $this->postJson(route('organizations.store', $params));
        $response->assertOk();
        $this->assertDatabaseHas('organizations', [
            'name' => 'Wa central mosque',
            'digital_address' => 'XW-0006-0904'
        ]);
        $response->assertJson([
            'data' => [
                'error' => false,
                'message' => 'Organization created successfully'
            ]
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_shows_details_of_an_organization()
    {
        $organization = factory(Organization::class)->create([
            'name' => 'Taqwa foundation'
        ]);
        $response = $this->getJson(route('organizations.show', $organization));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'phone_number', 'digital_address', 'about', 'is_active', 'created_at', 'admins']
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_organizations()
    {
        factory(Organization::class, 2)->create();
        $response = $this->getJson(route('organizations.index'));
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'digital_address']
            ]
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authorized_user_can_update_details_of_an_organization()
    {
        $organization = factory(Organization::class)->create([
            'name' => 'Taqwa foundation',
        ]);
        $params = [
            'name' => 'Taqwa of Allah'
        ];
        $response = $this->patchJson(route('organizations.update', $organization), $params);
        $response->assertOk();
        $this->assertDatabaseHas('organizations', [
            'name' => 'Taqwa of Allah'
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authorized_user_can_delete_an_organization()
    {
        $organization = factory(Organization::class)->create([
            'name' => 'Taqwa foundation',
        ]);
        $params = [
            'permanent' => true,
        ];
        $response = $this->deleteJson(route('organizations.destroy', $organization), $params);
        $response->assertNoContent(204);
        $this->assertDatabaseMissing('organizations', [
            'name' => 'Taqwa foundation',
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_donations_made_for_an_organization()
    {
        $organization = factory('App\Models\Organization')->create();
        //Create donations for this organization
        factory('App\Models\Donation', 2)->create([
            'organization_id' => $organization->id,
        ]);
        $response = $this->getJson(route('organization.donations.index', $organization));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'amount', 'currency', 'status', 'created_at']
            ]
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_returns_stats_information_of_an_organization()
    {
        $organization = factory('App\Models\Organization')->create();
        //Add 2 admins
        $users = factory('App\Models\User', 2)->create();
        $organization->admins()->attach($users->pluck('id'));
        //Make 2 donations
        factory('App\Models\Donation', 3)->create([
            'amount' => 100,
            'organization_id' => $organization->id,
        ]);
        $response = $this->getJson(route('organization.statistics', $organization));
        $response->assertOk();
        $response->assertJsonFragment([
            'admins_count' => 2,
            'donations_count' => 3,
            'donations_sum' => 300,
        ]);
    }
}
