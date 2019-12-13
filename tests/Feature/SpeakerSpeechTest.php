<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpeakerSpeechTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function it_lists_speeches_by_a_speaker()
    {
        $speaker = factory('App\Models\Speaker')->create();
        $speeches = factory('App\Models\Speech', 2)->create();
        $speaker->speeches()->saveMany($speeches);
        
        $response = $this->json('GET', route('speaker.speeches', $speaker));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }
}
