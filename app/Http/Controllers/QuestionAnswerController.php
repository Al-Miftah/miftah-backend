<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Resources\AnswerCollection;
use App\Http\Resources\QuestionResource;
use App\Models\Answer;

class QuestionAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:speaker')->only('store');
    }

    public function index(Request $request, Question $question)
    {
        $answers = $question->answers()->paginate();
        return new AnswerCollection($answers);
    }

    /**
     * Answer a question
     * by a speaker
     */
    public function store(StoreAnswerRequest $request, Question $question)
    {
        $speaker = auth('speaker')->user();
        $answer = new Answer;
        $answer->description = $request->input('description');
        $answer->answerer()->associate($speaker);
        $question->answers()->save($answer);

        return new QuestionResource($question->load('answers'));
    }
}
