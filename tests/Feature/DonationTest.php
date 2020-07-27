<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class DonationTest extends TestCase
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
        $this->seed(['PlanSeeder']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_creates_a_new_donation()
    {
        $params = [
            'transaction_reference' => '89348347273',
            'amount' => 5,
            'currency' => 'GHS',
            'payment_type' => 'onetime',
            'gateway' => 'paystack',
            'channel' => 'mobile_money',
            'additional_information' => 'Maasha Allah',
            'user_id' => factory('App\Models\User')->create()->id,
            'organization_id' => factory('App\Models\Organization')->create()->id,
        ];
        $response = $this->postJson(route('donations.store'), $params);
        $response->assertOk();
        $response->assertJsonFragment([
            'error' => false,
            'message' => 'Donation recorded successfully'
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_donations()
    {
        factory('App\Models\Donation', 2)->create();
        $response = $this->getJson(route('donations.index'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_filters_donations_by_a_search_criteria()
    {
        factory('App\Models\Donation')->create([
            'channel' => 'card'
        ]);
        factory('App\Models\Donation', 2)->create([
            'channel' => 'mobile_money'
        ]);
        $query = [
            'channel' => 'card'
        ];
        $response = $this->getJson(route('donations.index', $query));
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_shows_details_of_a_donation()
    {
        $donation = factory('App\Models\Donation')->create([
            'amount' => 10,
            'currency' => 'GHS',
        ]);
        $response = $this->getJson(route('donations.show', $donation));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['id', 'amount', 'gateway', 'currency', 'channel', 'additional_information', 'donated_by', 'donated_for']
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function an_authorized_user_can_delete_a_donation()
    {
        $donation = factory('App\Models\Donation')->create([
            'transaction_reference' => 934948534,
            'amount' => 15,
            'currency' => 'GHS',
        ]);
        $params = [
            'permanent' => true,
        ];
        $response = $this->deleteJson(route('donations.destroy', $donation), $params);
        $response->assertNoContent(204);
        $this->assertDatabaseMissing('donations', [
            'transaction_reference' => 934948534,
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_paystack_plans()
    {
        $response = $this->getJson(route('paystack.plans'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'plan_code', 'description']
            ]
        ]);
    }
}
