<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class LoginUserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    /**
     *@test
     */
    public function it_logs_a_user_in_if_they_provide_valid_credentials()
    {
        factory('App\Models\User')->create([
            'email' => 'ibnsamad@mitfah.com',
            'password' => bcrypt('secretXYZ')
        ]);

        $input = [
            'email' => 'ibnsamad@mitfah.com',
            'password' => 'secretXYZ',
        ];

        $response = $this->json('POST', route('user.auth.login'), $input);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['access_token', 'token_expiration', 'token_type', 'user']
        ]);
    }

    /**
     * @test
     */
    public function user_login_fails_if_provided_input_is_invalid()
    {
        factory('App\Models\User')->create([
            'email' => 'ibnsamad@mitfah.com',
            'password' => bcrypt('secretXYZ')
        ]);

        $input = [
            'email' => 'ibnsamad@mitfah.com',
            'password' => 'secret123',
        ];

        $response = $this->json('POST', route('user.auth.login'), $input);
        $response->assertStatus(401);
    }
}
