<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFavoriteAnswerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function an_authenticated_user_can_favorite_a_answer()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $question = factory('App\Models\Question')->create();
        $answer = factory('App\Models\Answer')->create([
            'question_id' => $question->id,
        ]);
        
        $response = $this->json('POST', route('user.favorites.answers.store', $answer));
        $response->assertOk();
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'favorable_type' => 'answers',
            'favorable_id' => $answer->id, 
        ]);
    }

    /**
     * @test
     */
    public function it_lists_user_favorite_answers()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $answers = factory('App\Models\Answer', 2)->create();
        
        foreach ($answers as $answer) {
            factory('App\Models\Favorite')->create([
                'user_id' => $user->id,
                'favorable_type' => 'answers',
                'favorable_id' => $answer->id,
            ]);
        }
        $response = $this->json('GET', route('user.favorites.answers.index'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }

    /**
     * @test
     */
    public function it_removes_a_question_from_user_favorite_questions()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $answer = factory('App\Models\Answer')->create();
        $favorite = factory('App\Models\Favorite')->create([
            'user_id' => $user->id,
            'favorable_id' => $answer->id,
            'favorable_type' => 'answers'
        ]);

        //Unfavorite
        $response = $this->json('DELETE', route('user.favorites.answers.destroy', $answer));
        $response->assertNoContent();
        $this->assertCount(0, $user->favorites()->where('favorable_type', 'answers')->get());
    }
}
