<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpeakerFollowerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     *@test
     */
    public function an_authenticated_user_can_follow_a_speaker()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);
        $speaker = factory('App\Models\Speaker')->create();
        $response = $this->json('POST', route('speakers.followers.store', $speaker));
        $response->assertOk();
        $this->assertTrue($speaker->followers->contains($user));
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
        $this->json('POST', route('speakers.followers.store', $speaker));
        //unfollow
        $this->json('POST', route('speakers.followers.store', $speaker));
        //Assert user is no more part of those following the speaker
        $this->assertFalse($speaker->followers->contains($user));
        
    }

    /**
     * @test
     */
    public function it_lists_all_followers_of_a_speaker()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);
        $speaker = factory('App\Models\Speaker')->create();

        //Add user to speaker followers
        $speaker->followers()->attach($user->id);
        $response = $this->json('GET', route('speakers.followers.index', $speaker));
        $response->assertOk();
        $response->assertJsonCount(1, 'data');
    }
}
