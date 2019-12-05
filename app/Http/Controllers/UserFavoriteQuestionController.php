<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;

class UserFavoriteQuestionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('api')->user();
        $ids = Favorite::where([
            'favorable_type' => 'questions',
            'user_id' => $user->id,
        ])->pluck('favorable_id');
        $questions = Question::whereIn('id', $ids)->paginate();
        return new QuestionCollection($questions);

    }


    public function store(Request $request, Question $question)
    {
        $user = auth('api')->user();

        $favorite = new Favorite;
        $favorite->user()->associate($user);
        $question->favorites()->save($favorite);
        return new QuestionResource($question);
    }

    public function destroy(Request $request, Question $question)
    {
        $user = auth('api')->user();
        $question->favorites()->where('user_id', $user->id)->delete();
        return response()->noContent();
    }
}
