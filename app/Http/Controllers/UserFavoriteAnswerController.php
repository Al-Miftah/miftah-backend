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
        $ids = Favorite::where([
            'favorable_type' => 'answers',
            'user_id' => $user->id,
        ])->pluck('favorable_id');
        $answers = Answer::whereIn('id', $ids)->paginate();
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

        $ids = Favorite::where([
            'favorable_type' => 'answers',
            'user_id' => $user->id,
        ])->pluck('favorable_id');
        $answers = Answer::whereIn('id', $ids)->paginate();
        return new AnswerCollection($answers);
    }

    public function destroy(Answer $answer)
    {
        $user = auth('api')->user();
        $answer->favorites()->where('user_id', $user->id)->delete();
        return response()->noContent();
    }
}
