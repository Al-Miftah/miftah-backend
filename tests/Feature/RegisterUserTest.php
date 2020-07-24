<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class RegisterUserTest extends TestCase
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
    public function a_user_is_registered_if_provided_details_are_valid()
    {
        $input = [
            'name' => 'Ibrahim Samad',
            'username' => 'ultrasamad',
            'email' => 'ibnsamad@miftah.com',
            'password' => 'secretXYZ',
            'password_confirmation' => 'secretXYZ'
        ];

        $response = $this->json('POST', route('user.auth.register'), $input);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['access_token', 'token_type', 'token_expiration', 'user']
        ]);
    }
}
