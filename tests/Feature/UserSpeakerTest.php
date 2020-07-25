<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserSpeakerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_lists_all_speakers_a_user_is_following()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        //create some speakers and make user follow them
        $speakers = factory('App\Models\Speaker', 2)->create();
        $user->speakers()->attach($speakers->pluck('id'));
        $response = $this->json('GET', route('users.speakers.index'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_unfollow_a_speaker()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);
        $speaker = factory('App\Models\Speaker')->create();
        //follow
        $this->json('POST', route('users.speakers.store', $speaker));
        //unfollow
        $response = $this->json('POST', route('users.speakers.store', $speaker));
        //Assert user is no more part of those following the speaker
        $response->assertOk();
        $this->assertFalse($speaker->followers->contains($user));

        
    }

    /**
     *@test
     */
    public function an_authenticated_user_can_follow_a_speaker()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);
        $speaker = factory('App\Models\Speaker')->create();
        $response = $this->json('POST', route('users.speakers.store', $speaker));
        $response->assertOk();
        $this->assertTrue($speaker->followers->contains($user));
    }
}
