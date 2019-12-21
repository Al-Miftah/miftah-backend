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

        $speeches = $this->favoriteSpeeches($user);
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
        
        $speeches = $this->favoriteSpeeches($user);
        return new SpeechCollection($speeches);
    }

    /**
     * Consider moving to Model
     */
    private function favoriteSpeeches($user)
    {
        $ids = $user->favorites()->where([
            'favorable_type' => 'speeches',
        ])->pluck('favorable_id');
        
        return Speech::whereIn('id', $ids)->paginate();
    }
}
