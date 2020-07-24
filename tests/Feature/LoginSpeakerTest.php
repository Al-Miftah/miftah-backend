<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class LoginSpeakerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');

    }

    /**
     * @test
     */
    public function it_logs_in_a_speaker_and_generate_access_token()
    {
        factory('App\Models\Speaker')->create([
            'email' => 'yakubu@gmail.com',
            'password' => bcrypt('secret123'),
        ]);

        $input = [
            'email' => 'yakubu@gmail.com',
            'password' => 'secret123',
        ];
        $response = $this->json('POST', route('speaker.auth.login'), $input);
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['access_token', 'token_type', 'token_expiration']
        ]);
    }

    /**
     * @test
     */
    public function login_fails_if_provided_credentials_are_invalid()
    {
        factory('App\Models\Speaker')->create([
            'email' => 'yakufu@gmail.com',
            'password' => bcrypt('secret123'),
        ]);

        $input = [
            'email' => 'yakufu@gmail.com',
            'password' => 'secretABC',
        ];
        $response = $this->json('POST', route('speaker.auth.login'), $input);
        $response->assertStatus(401);
        $response->assertJsonMissing([
            'access_token'
        ]);
    }
}
