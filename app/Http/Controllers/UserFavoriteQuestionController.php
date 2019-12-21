<?php

namespace App\Http\Controllers;

use App\Models\{Favorite, Question};
use App\Http\Resources\QuestionCollection;

class UserFavoriteQuestionController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();

        $questions = $this->favoriteQuestions($user);
        return new QuestionCollection($questions);

    }


    public function store(Question $question)
    {
        $user = auth('api')->user();

        $favorite = $question->favorites()->where('user_id', $user->id)->first();
        if ($favorite) {
            $favorite->delete();
        }else {
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
        $ids = $user->favorites()->where('favorable_type', 'questions')->pluck('favorable_id');
        return Question::whereIn('id', $ids)->paginate();
    }
}
