<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterSpeakerTest extends TestCase
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
    public function it_registers_a_speaker_and_generates_access_token()
    {
        $input = [
            'first_name' => 'Salifu',
            'last_name' => 'Yakubu',
            'phone_number' => '+2335412345',
            'email' => 'yakufu@gmail.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'city' => 'Wa',
            'location_address' => 'Dondoli, Wa',
            'bio' => $this->faker->sentence,
            'avatar' => null,
        ];

        $response = $this->json('POST', route('speaker.auth.register'), $input);
        $response->assertOk();
        $response->assertJsonStructure(['access_token', 'token_type', 'token_expiration']);
        $response->assertJsonFragment([
            'email' => 'yakufu@gmail.com', 
        ]);
    }
}
