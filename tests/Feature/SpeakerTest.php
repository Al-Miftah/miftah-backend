<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Speaker;

class SpeakerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
    }


    /** @test */
    public function it_creates_a_speaker_and_associate_it_with_a_user()
    {
        $input = [
            'name' => 'Yakubu Salifu',
            'email' => 'sheikhsalifu@yahoo.com',
            'phone' => '+233540362282',
            'address' => 'Chaggu, Wa East - Upper West',
            'bio' => 'An islamic cleric with many years of experience in Chaggu'
        ];

        $response = $this->json('POST', route('speakers.store'), $input);
        $response->assertOk();
        $this->assertDatabaseHas('speakers', [
            'name' => 'Yakubu Salifu'
        ]);
    }

    /** @test */
    public function update_speaker()
    {
        //$speaker = factory(Speaker::class)->create();
        $response = $this->json('PATCH', '/api/speakers/'.$this->speaker->id);
        $response->assertStatus(200);
        
        $this->speaker->update(['name' => 'Imori Abu']);
        $this->assertDatabaseHas('speakers', ['name' => 'Imori Abu']);
    }

    /** @test */
    public function show_details_of_a_specific_speaker()
    {
        $speaker = $this->speaker;

        $response = $this->json('GET', '/api/speakers/'.$speaker->id);
        $response->assertStatus(200);

        $content = $response->getData();
        $this->assertEquals($content->data->name, $speaker->name);
    }

    /** @test */
    public function list_all_speakers()
    {
        $response = $this->json('GET', '/api/speakers');
        $response->assertStatus(200);

        //TODO Refact to use only setUp() in model creation
        $speakers = factory(Speaker::class, 2)->create(); 
        $this->assertCount(3, Speaker::get()); //3 because 1 is already created in setUp() 

        //TODO Check full json structure of returned model
        $response->assertJsonStructure([
            'data' => 'data'
        ]);
    }
}
