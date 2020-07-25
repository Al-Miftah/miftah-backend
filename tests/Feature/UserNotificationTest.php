<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Notifications\NewSpeechAvailable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserNotificationTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function it_lists_notifications_of_a_user()
    {
        $user = factory(User::class)->create([
            'email' => 'johdoe@example.com',
        ]);
        $this->authenticate($user);

        //Send a notification
        $speech = factory('App\Models\Speech')->create();
        $speaker = factory('App\Models\Speaker')->create();

        Notification::send($user, new NewSpeechAvailable($speech, $speaker));

        $response = $this->json('GET', route('user.notifications.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'payload', 'created_at']
            ]
        ]);
    }
}
