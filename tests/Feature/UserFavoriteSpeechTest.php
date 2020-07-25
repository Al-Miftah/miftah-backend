<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserFavoriteSpeechTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /**
     * @test
     */
    public function an_authenticated_user_can_favorite_a_speech()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $speech = factory('App\Models\Speech')->create();
        $response = $this->json('POST', route('user.favorites.speeches.store', $speech));
        $response->assertOk();
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'favorable_type' => 'speeches',
            'favorable_id' => $speech->id, 
        ]);
    }

    /**
     * @test
     */
    public function it_lists_user_favorites_speeches()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $speeches = factory('App\Models\Speech', 2)->create();
        foreach ($speeches as $speech) {
            factory('App\Models\Favorite')->create([
                'user_id' => $user->id,
                'favorable_type' => 'speeches',
                'favorable_id' => $speech->id,
            ]);
        }
        
        $response = $this->json('GET', route('user.favorites.speeches.index'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_unfavorite_a_speech()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $speech = factory('App\Models\Speech')->create();

        $favorite = factory('App\Models\Favorite')->create([
            'user_id' => $user->id,
            'favorable_id' => $speech->id,
            'favorable_type' => 'speeches'
        ]);

        //Unfavorite
        $response = $this->json('POST', route('user.favorites.speeches.store', $speech));
        $favorites = $speech->favorites()->where('user_id', $user->id)->get();
        $this->assertCount(0, $favorites);
        $response->assertJsonCount(0, 'data');
    }
}
