<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class SpeechNotificationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     *@test
     */
    public function it_sends_new_speech_notification_followers_of_a_speaker()
    {
        //Create a speaker
        $speaker = factory('App\Models\Speaker')->create();
        //create some users
        $users = factory('App\Models\User', 2)->create();
        //Make users follow speaker
        $speaker->followers()->attach($users->pluck('id'));
        //Create new speech for speaker
        $speech = factory('App\Models\Speech')->create([
            'speaker_id' => $speaker->id,
        ]);

        $this->assertCount(1, $users[0]->notifications);
    }
}
