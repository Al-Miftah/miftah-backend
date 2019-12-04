<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_lists_all_tags()
    {
        factory('App\Models\Tag', 5)->create();
        $response = $this->json('GET', route('tags.index'));
        $response->assertOk();
        $response->assertJsonCount(5, 'data');
    }

    /**
     * @test
     */
    public function it_create_new_tags()
    {
        $input = [
            'tags' => ['Marriage', 'Fasting', 'Salat']
        ];
        $response = $this->json('POST', route('tags.store'), $input);
        $response->assertOk();
        $this->assertDatabaseHas('tags', [
            'slug' => 'marriage',
        ]);
        $response->assertJsonFragment([
            'message' => 'Tags created successfully!'
        ]);
    }

    /**
     * @test
     */
    public function it_updates_a_tag()
    {
        $tag = factory('App\Models\Tag')->create([
            'name' => 'Ramadanm',
        ]);
        $input = [
            'name' => 'Ramadan',
        ];
        $response = $this->json('PATCH', route('tags.update', $tag), $input);
        $this->assertDatabaseHas('tags', [
            'name' => 'Ramadan',
        ]);
        $response->assertJsonFragment([
            'name' => 'Ramadan',
        ]);
    }

    /**
     * @test
     */
    public function it_deletes_a_tag()
    {
        $tag = factory('App\Models\Tag')->create([
            'name' => 'Nawafil',
        ]);
        $response = $this->json('DELETE', route('tags.destroy', $tag));
        $this->assertDatabaseMissing('tags', [
            'name' => 'Nawafil',
        ]);
        $response->assertNoContent();
    }

}
