<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserTopicTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function a_authenticated_user_can_follow_a_topic()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $topic = factory('App\Models\Topic')->create();
        $response = $this->json('POST', route('users.topics.store', $topic));
        $response->assertOk();
        $this->assertTrue($user->topics->contains($topic));
    }

    /**
     * @test
     */
    public function it_lists_all_topics_a_user_is_following()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $topics = factory('App\Models\Topic', 2)->create();
        //Attach topics to user
        $user->topics()->attach($topics->pluck('id'));
        $response = $this->json('GET', route('users.topics.index'));
        $response->assertJsonCount(2, 'data');
    }
}
