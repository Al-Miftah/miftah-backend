<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class QuestionAnswerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function it_lists_answers_to_a_question()
    {
        $question = factory('App\Models\Question')->create();
        $answers = factory('App\Models\Answer', 2)->create();
        $question->answers()->saveMany($answers);
        $response = $this->json('GET', route('question.answers.index', $question));
        $response->assertOk();
        $response->assertJsonCount(2, 'data');

    }

    /**
     * @test
     */
    public function a_speaker_can_answer_a_question()
    {
        $speaker = factory('App\Models\Speaker')->create();
        $this->authenticate($speaker, 'speaker');
        $question = factory('App\Models\Question')->create([
            'title' => 'Tawhid',
            'description' => 'What is Tawhid?',
        ]);
        $input = [
            'description' => 'Tawhid is the indivisible oneness concept of monotheism in islam.',
        ];

        $response = $this->json('POST', route('question.answers.store', $question), $input);
        $response->assertOk();
        $this->assertDatabaseHas('answers', [
            'description' => 'Tawhid is the indivisible oneness concept of monotheism in islam.',
            'question_id' => $question->id,
            'speaker_id' => $speaker->id,
        ]);
    }
}
