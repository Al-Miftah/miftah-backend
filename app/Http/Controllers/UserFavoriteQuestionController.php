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

        $questions = $this->favoriteQuestions($user);
        return new QuestionCollection($questions);

    }


    public function store(Request $request, Question $question)
    {
        $user = auth('api')->user();

        $favorite = $question->favorites()->where('user_id', $user->id)->first();
        if ($favorite) {
            //remove it
            $favorite->delete();
        }else {
            //create it
            $favorite = new Favorite;
            $favorite->user()->associate($user);
            $question->favorites()->save($favorite);
        }

        $questions = $this->favoriteQuestions($user);
        return new QuestionCollection($questions);
    }

    /**
     * Consider moving to Model
     */
    private function favoriteQuestions($user)
    {
        $ids = $user->favorites()->where([
            'favorable_type' => 'questions',
        ])->pluck('favorable_id');
        
        return Question::whereIn('id', $ids)->paginate();
    }
}
