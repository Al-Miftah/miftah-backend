<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SpeechTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_creates_a_new_speech()
    {
        Storage::fake('local');

        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $speaker = factory('App\Models\Speaker')->create();
        $language = factory('App\Models\Language')->create();
        $topic = factory('App\Models\Topic')->create();

        $input = [
            'title' => 'Women rights in Islam',
            'speech' => UploadedFile::fake()->create('recording.mp3'),
            'summary' => $this->faker->sentence,
            'cover_photo' => UploadedFile::fake()->image('recording_cover.png'),
            'speaker_id' => $speaker->id,
            'language_id' => $language->id,
            'topic_id' => $topic->id,
        ];
        
        $response = $this->json('POST', route('speeches.store'), $input);
        $response->assertStatus(201);
        $this->assertDatabaseHas('speeches', [
            'title' => 'Women rights in Islam'
        ]);
        $response->assertJsonFragment([
            'title' => 'Women rights in Islam',
        ]);
        $folder = 'public/uploads/speeches/audio';
        $this->assertCount(1, Storage::files($folder));
        $this->assertCount(1, Storage::files('public/uploads/speeches/photos'));
        
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
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

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
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);
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
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);
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
