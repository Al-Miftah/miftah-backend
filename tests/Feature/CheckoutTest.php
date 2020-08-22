<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class CheckoutTest extends TestCase
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
        $this->authenticate();
        $this->seed(['PlanSeeder']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_lists_all_paystack_plans()
    {
        $response = $this->getJson(route('checkout.paystack.plans'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'paystack_plan_code', 'description']
            ]
        ]);
    }
}
