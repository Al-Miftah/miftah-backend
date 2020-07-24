<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class TopicTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(['RolesAndPermissionsSeeder']);
        $admin = factory('App\Models\User')->create();
        $admin->givePermissionTo(['Create Topic', 'Update Topic', 'Delete Topic']);
        $this->authenticate($admin);
    }

    /** @test */
    public function an_authorized_admin_can_creates_a_new_topic()
    {
        $input = [
            'title' => 'Marriage in Islam',
            'description' => 'Some long description'
        ];

        $response = $this->json('POST', route('topics.store'), $input);
        $response->assertOk();
        $this->assertDatabaseHas('topics', [
            'title' => 'Marriage in Islam',
            'slug' => 'marriage-in-islam'
        ]);
        $response->assertJsonFragment([
            'message' => 'Topic created successfully'
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
    public function an_authorized_admin_can_deletes_a_topic()
    {
        $topic = factory(Topic::class)->create();
        $response = $this->json('DELETE', route('topics.destroy', $topic), ['permanent' => true]);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('topics', [
            'id' => $topic->id,
        ]);
    }
}
