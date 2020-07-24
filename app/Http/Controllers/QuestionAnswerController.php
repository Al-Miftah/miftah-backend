<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Resources\AnswerCollection;
use App\Http\Resources\QuestionResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class QuestionAnswerController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth:speaker')->only('store');
    }

    /**
     * List Questions
     *
     * @param Request $request
     * @param Question $question
     * @return void
     */
    public function index(Request $request, Question $question)
    {
        $answers = $question->answers()->paginate();
        return new AnswerCollection($answers);
    }

    /**
     * User ask a question
     *
     * @param StoreAnswerRequest $request
     * @param Question $question
     * @return void
     */
    public function store(StoreAnswerRequest $request, Question $question)
    {
        $speaker = auth('speaker')->user();
        $answer = new Answer;
        $answer->description = $request->input('description');
        $answer->answerer()->associate($speaker);
        $question->answers()->save($answer);
        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'Question logged successfully',
            ]
        ]);
    }
}
