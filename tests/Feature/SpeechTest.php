<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Speech;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class SpeechTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(['RolesAndPermissionsSeeder', 'TagsTableSeeder']);
        $admin = factory('App\Models\User')->create();
        $admin->givePermissionTo('Create Speech', 'Update Speech', 'Force delete Speech');
        $this->authenticate($admin);
        
    }

    /**
     * @test
     */
    public function it_creates_a_new_speech()
    {
        $speaker = factory('App\Models\Speaker')->create();
        $topic = factory('App\Models\Topic')->create();

        $input = [
            'title' => 'Women rights in Islam',
            'url' => 'http://firebase.storage.com/recording1.mp3',
            'summary' => $this->faker->sentence,
            'cover_photo' => 'https://storage.firebase.com/recording_cover.png',
            'speaker_id' => $speaker->id,
            'topic_id' => $topic->id,
            'tags' => ['repentance', 'fasting']
        ];
        
        $response = $this->json('POST', route('speeches.store'), $input);
        $response->assertStatus(201);
        $this->assertDatabaseHas('speeches', [
            'title' => 'Women rights in Islam'
        ]);
        $this->assertCount(2, Speech::whereTitle('Women rights in Islam')->first()->tags);
    }

    /**
     * @test
     */
    public function it_lists_all_speeches()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        factory('App\Models\Speech', 2)->create();
        $response = $this->json('GET', route('speeches.index'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

      /**
     * @test
     */
    public function it_shows_details_of_a_speech()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $speech = factory('App\Models\Speech')->create([
            'title' => 'The last ten days of Ramadan'          
        ]);

        $response = $this->json('GET', route('speeches.show', $speech));
        $response->assertOk();
        $response->assertJsonFragment([
            'title' => 'The last ten days of Ramadan' 
        ]);
    }

    /**
     * @test
     */
    public function it_updates_details_of_a_speech()
    {
        $speech = factory('App\Models\Speech')->create([
            'title' => 'Night of Power'          
        ]);

        $input = [
            'summary' => 'A speech on Lailatul Qadar'
        ];

        $response = $this->json('PATCH', route('speeches.update', $speech), $input);
        $response->assertOk();
        $response->assertJsonFragment([
            'summary' => 'A speech on Lailatul Qadar'
        ]);
    }

    /**
     * @test
     */
    public function it_soft_deletes_a_speech()
    {
        $speech = factory('App\Models\Speech')->create();

        $response = $this->json('DELETE', route('speeches.destroy', $speech));
        $this->assertSoftDeleted('speeches', [
            'id' => $speech->id,
        ]);
        $response->assertNoContent();
    }

    /**
     * @test
     */
    public function it_deletes_a_speech_permanently()
    {
        $speech = factory('App\Models\Speech')->create();

        $input = [
            'permanent' => true,
        ];
        $response = $this->json('DELETE', route('speeches.destroy', $speech), $input);
        $this->assertDatabaseMissing('speeches', [
            'id' => $speech->id,
        ]);
        $response->assertNoContent();
    }
}
