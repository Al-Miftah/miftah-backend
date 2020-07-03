<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TopicTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_creates_a_new_topic()
    {
        $input = [
            'title' => 'Marriage in Islam',
            'description' => 'Some long description'
        ];

        $response = $this->json('POST', route('topics.store'), $input);
        $response->assertStatus(201);
        $this->assertDatabaseHas('topics', [
            'title' => 'Marriage in Islam',
            'slug' => 'marriage-in-islam'
        ]);
        $response->assertJsonFragment([
            'title' => 'Marriage in Islam',
        ]);
        
    }

        /** @test */
        public function it_list_all_topics()
        {
            factory(Topic::class, 2)->create();
            $response = $this->json('GET', route('topics.index'));
            $response->assertOk();
            $response->assertJsonCount(2, 'data');
            $response->assertJsonStructure(['data']);
        }

    /** @test */
    public function it_updates_a_topic()
    {
        $topic = factory(Topic::class)->create();
        $input = [
            'title' => 'Updated title of topic'
        ];
        $response = $this->json('PATCH', route('topics.update', $topic), $input);
        $response->assertOk();
        $this->assertDatabaseHas('topics', [
            'title' => 'Updated title of topic'
        ]);
        $response->assertJsonFragment([
            'title' => 'Updated title of topic'
        ]);
    }

    /** @test */
    public function it_soft_deletes_a_topic()
    {
        $topic = factory(Topic::class)->create();
        $response = $this->json('DELETE', route('topics.destroy', $topic));
        $response->assertStatus(204);
        $this->assertSoftDeleted('topics', [
            'id' => $topic->id
        ]);
    }

    /** @test */
    public function it_deletes_a_topic_permanently()
    {
        $topic = factory(Topic::class)->create();
        $response = $this->json('DELETE', route('topics.destroy', $topic), ['permanent' => true]);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('topics', [
            'id' => $topic->id,
        ]);
    }
}
