<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagSpeechTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_lists_all_speeches_under_a_specific_tag()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $speaker = factory('App\Models\Speaker')->create();

        $tag = factory('App\Models\Tag')->create();

        $speech1 = factory('App\Models\Speech')->create([
            'title' => 'Seerah of the prophet',
            'speaker_id' => $speaker->id,
        ]);

        $speech2 = factory('App\Models\Speech')->create([
            'title' => 'Wives of the prophet',
            'speaker_id' => $speaker->id,
        ]);

        $speech1->tags()->attach($tag->id);
        $speech2->tags()->attach($tag->id);

        $response = $this->json('GET', route('tags.speeches.index', $tag));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }
}
