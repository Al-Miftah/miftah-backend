<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFavoriteQuestionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function an_authenticated_user_can_favorite_a_question()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);
        $question = factory('App\Models\Question')->create();
        $response = $this->json('POST', route('user.favorites.questions.store', $question));
        $response->assertOk();
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'favorable_type' => 'questions',
            'favorable_id' => $question->id, 
        ]);
    }

    /**
     * @test
     */
    public function it_lists_user_favorite_questions()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        $questions = factory('App\Models\Question', 2)->create();
        
        foreach ($questions as $question) {
            factory('App\Models\Favorite')->create([
                'user_id' => $user->id,
                'favorable_type' => 'questions',
                'favorable_id' => $question->id,
            ]);
        }
        $response = $this->json('GET', route('user.favorites.questions.index'));
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

        $question = factory('App\Models\Question')->create();
        $favorite = factory('App\Models\Favorite')->create([
            'user_id' => $user->id,
            'favorable_id' => $question->id,
            'favorable_type' => 'questions'
        ]);

        //Unfavorite
        $response = $this->json('DELETE', route('user.favorites.questions.destroy', $question));
        $response->assertNoContent();
        $this->assertCount(0, $user->favorites()->where('favorable_type', 'questions')->get());
    }
}
