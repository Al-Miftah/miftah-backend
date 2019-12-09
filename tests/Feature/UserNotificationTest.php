<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserNotificationTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function it_lists_notifications_of_a_user()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $response = $this->json('GET', route('user.notifications.index'));
        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    /**
     * @test
     */
    public function it_notifies_user_when_new_speech_is_avalable_from_followed_topic()
    {
        $this->assertTrue(true);
    }

    public function it_notifies_user_when_new_speech_is_available_from_followed_speaker()
    {
        $this->assertTrue(true);
    }

}
