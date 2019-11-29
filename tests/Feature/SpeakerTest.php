<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Speaker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpeakerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
    }


    /** @test */
    public function it_creates_a_speaker()
    {
        $input = [
            'first_name' => 'Salifu',
            'last_name' => 'Yakubu',
            'email' => 'sheikhsalifu@yahoo.com',
            'phone_number' => '+233540362282',
            'location_address' => 'Chaggu, Wa East - Upper West',
            'bio' => 'An islamic cleric with many years of experience in Chaggu',
            'city' => 'Wa',
            'password' => 'secret123',
            'password_confirmation' => 'secret123'
        ];

        $response = $this->json('POST', route('speakers.store'), $input);
        $response->assertStatus(201);
        $this->assertDatabaseHas('speakers', [
            'email' => 'sheikhsalifu@yahoo.com'
        ]);
        $response->assertJsonFragment([
            'first_name' => 'Salifu'
        ]);
    }

    /** @test */
    public function it_updates_details_of_aspeaker()
    {
        $speaker = factory(Speaker::class)->create();
        $input = [
            'first_name' => 'Salih'
        ];
        $response = $this->json('PATCH', route('speakers.update', $speaker), $input);
        $response->assertOk();
        $this->assertDatabaseHas('speakers', [
            'first_name' => 'Salih'
        ]);
        $response->assertJsonFragment([
            'first_name' => 'Salih'
        ]);
    }

    /** @test */
    public function it_lists_all_speakers()
    {
        factory('App\Models\Speaker', 2)->create();
        $response = $this->json('GET', route('speakers.index'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    /**
     * @test
     */
    public function it_soft_deletes_a_speaker()
    {
        $speaker = factory('App\Models\Speaker')->create();
        $response = $this->json('DELETE', route('speakers.destroy', $speaker));
        $response->assertNoContent(204);
        $this->assertSoftDeleted('speakers', [
            'id' => $speaker->id,
        ]);
    }

    /**
     * @test
     */
    public function it_deletes_a_speaker_permanently()
    {
        $speaker = factory('App\Models\Speaker')->create();
        $response = $this->json('DELETE', route('speakers.destroy', $speaker), ['permanent' => true]);
        $response->assertNoContent(204);
        $this->assertDatabaseMissing('speakers', [
            'id' => $speaker->id,
        ]);
    }
}
