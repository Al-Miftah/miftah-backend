<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\QuestionCollection;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    public function index()
    {
        $questions = Question::with('answers')->paginate();
        return new QuestionCollection($questions);
    }

    public function store(StoreQuestionRequest $request)
    {   $user = auth('api')->user();

        $question = new Question;
        $question->title = $request->input('title');
        $question->description = $request->input('description');
        $question->asker()->associate($user);
        $question->save();

        return new QuestionResource($question);
    }

    public function show(Question $question)
    {
        $data = $question->load('answers');
        return new QuestionResource($data);
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'description'));
        return new QuestionResource($question->fresh());
    }

    public function destroy(Request $request, Question $question)
    {
        if ($request->permanent) {
            $question->forceDelete();
        }else {
            $question->delete();
        }
        return response()->noContent();
    }
}
