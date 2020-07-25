<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class LogoutUserTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function it_revokes_access_token_and_logout_user()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $response = $this->json('GET', route('user.auth.logout'));
        $response->assertOk();
        $response->assertJsonFragment([
            'data' => [
                'error' => false,
                'message' => 'User logged out successfully'
            ]
        ]);
    }
}
