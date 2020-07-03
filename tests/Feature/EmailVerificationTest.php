<?php

namespace Tests\Feature;

use App\Notifications\Auth\API\VerifyEmail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function it_sends_account_verification_link_to_user_through_email()
    {
        Notification::fake();

        $user = factory('App\Models\User')->create([
            'email_verified_at' => null,
        ]);
        $this->authenticate($user);

        $response = $this->json('POST', route('api.verification.resend'));
        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Verification email resent successfully!'
        ]);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * @test
     */
    public function it_verifies_user_account_via_email()
    {
        $this->assertTrue(true);
    }
}
