<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\AnswerCollection;


class UserFavoriteAnswerController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        
        $answers = $this->favoriteAnswers($user);
        return new AnswerCollection($answers);
    }

    public function store(Request $request, Answer $answer)
    {
        $user = auth('api')->user();

        $favorite = $answer->favorites()->where('user_id', $user->id)->first();
        if ($favorite) {
            $favorite->delete();
        }else {
            $favorite = new Favorite;
            $favorite->user()->associate($user);
            $answer->favorites()->save($favorite);
        }

        $answers = $this->favoriteAnswers($user);
        return new AnswerCollection($answers);
    }

    /**
     * Consider moving to Model
     */
    private function favoriteAnswers($user)
    {
        $ids = $user->favorites()->where([
            'favorable_type' => 'answers',
        ])->pluck('favorable_id');
        
        return Answer::whereIn('id', $ids)->paginate();
    }
}
