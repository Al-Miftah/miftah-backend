<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use App\Topic;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->topic = factory(Topic::class)->create();
    }

    /** @test */
    public function topic_is_not_created_if_validation_fails()
    {
        $response = $this->json('POST', '/api/topics');
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid.'
        ]);
    }

    /** @test */
    public function topic_is_created_if_validation_passes()
    {
        $topic = [
            'title' => 'Marriage in Islam'
        ];

        $response = $this->json('POST', '/api/topics', $topic);
        $response->assertStatus(200);

        $this->assertDatabaseHas('topics', [
            'title' => 'Marriage in Islam',
            'slug' => 'marriage-in-islam'
        ]);

        $response->assertJson(['status' => true]);
        $response->assertJson(['message' => 'Topic created successfully!']);
        $response->assertJson(['data' => $topic]);
    }

    /** @test */
    public function update_topic()
    {
        $response = $this->json('PATCH', '/api/topics/'.$this->topic->id);
        
        $this->topic->update(['title' => 'A new topic']);
        $this->assertDatabaseHas('topics', ['title' => 'A new topic']);
    }

    /** @test */
    public function list_all_topics()
    {
        $response = $this->json('GET', '/api/topics');
        $response->assertStatus(200);
        $topics = factory(Topic::class, 2)->create();

        $this->assertCount(3, Topic::get()); //3 because theres 1 already created in the setup method
        //TODO Assert response body
    }

    /** @test */
    public function soft_delete_a_topic()
    {
        $response = $this->json('DELETE', '/api/topics/'.$this->topic->id);
        $this->topic->delete();
        $this->assertSoftDeleted('topics', ['id' => $this->topic->id]);
    }

    /** @test */
    public function hard_delete_a_topic()
    {
        $response = $this->json('DELETE', '/api/topics/' . $this->topic->id, ['permanent' => true]);
        $response->assertStatus(201);
        $topic = Topic::withTrashed()
                        ->where('id', $this->topic->id)->first();
        $this->assertNull($topic);
    }
}
