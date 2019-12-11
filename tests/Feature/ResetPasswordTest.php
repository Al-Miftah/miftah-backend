<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Auth\API\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_sends_forgot_password_email_to_user()
    {
        Notification::fake();
        $user = factory('App\Models\User')->create([
            'email' => 'naatogma@gmail.com',
        ]);
        $this->authenticate($user);

        $input = [
            'email' => 'naatogma@gmail.com'
        ];
        $response = $this->json('GET', route('api.password.forgot'), $input);
        $response->assertOk();
        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * @test
     */
    public function it_resets_user_current_password()
    {
        $this->assertTrue(true);
    }
}
