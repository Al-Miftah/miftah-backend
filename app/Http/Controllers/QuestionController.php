<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionCollection;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Resources\Detail\QuestionResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class QuestionController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    /**
     * List all questions
     *
     * @return void
     */
    public function index()
    {
        $questions = Question::paginate();
        return new QuestionCollection($questions);
    }

    /**
     * Create a new question
     *
     * @param StoreQuestionRequest $request
     * @return void
     */
    public function store(StoreQuestionRequest $request)
    {   $user = auth('api')->user();

        $question = new Question;
        $question->title = $request->input('title');
        $question->description = $request->input('description');
        $question->asker()->associate($user);
        $question->save();

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'Question created successfully'
            ]
        ]);
    }

    /**
     * View details of a question
     *
     * @param Question $question
     * @return void
     */
    public function show(Question $question)
    {
        $data = $question->load('answers');
        return new QuestionResource($data);
    }

    /**
     * Update a question
     *
     * @param UpdateQuestionRequest $request
     * @param Question $question
     * @return void
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->only('title', 'description'));
        return new QuestionResource($question->fresh());
    }

    /**
     * Remove a question
     *
     * @param Request $request
     * @param Question $question
     * @return void
     */
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
