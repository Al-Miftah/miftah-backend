<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserQuestionTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_lists_all_questions_a_user_asked()
    {
        $user = factory('App\Models\User')->create();
        $this->authenticate($user);

        factory('App\Models\Question', 2)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->json('GET', route('user.questions'));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');
    }
}
