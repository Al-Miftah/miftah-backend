<?php

namespace App\Http\Controllers;

use App\Models\Speech;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Resources\SpeechCollection;
use App\Http\Resources\SpeechResource;

class UserFavoriteSpeechController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('api')->user();
        //todo refactor how speeches are fetched later
        $speechIds = Favorite::where([
            'favorable_type' => 'speeches',
            'user_id' => $user->id,
        ])->pluck('favorable_id');
        $speeches = Speech::whereIn('id', $speechIds)->paginate();
        return new SpeechCollection($speeches);
    }

    /**
     * Favorite/Unfavorite a speech
     */
    public function store(Request $request, Speech $speech)
    {
        $user = auth('api')->user();
        $favorite = $speech->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();
        }else {
            //else create it
            $favorite = new Favorite;
            $favorite->user()->associate($user);
            $speech->favorites()->save($favorite);
        }
        
        //Return back user favorited speeches
        $speechIds = Favorite::where([
            'favorable_type' => 'speeches',
            'user_id' => $user->id,
        ])->pluck('favorable_id');
        $speeches = Speech::whereIn('id', $speechIds)->paginate();
        return new SpeechCollection($speeches);
    }
}
