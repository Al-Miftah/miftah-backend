<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use App\Http\Resources\SpeakerCollection;

class UserSpeakerController extends Controller
{
    /**
     * Speakers user follows
     */
    public function index(Request $request, Speaker $speaker)
    {
        $user = auth('api')->user();
        $speakers = $user->speakers()->paginate();
        return new SpeakerCollection($speakers);
    }

    /**
     * Follow/Unfollow a speaker
     */
    public function store(Request $request, Speaker $speaker)
    {
        $user = auth('api')->user();
        $speaker->followers()->toggle($user->id);
        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'Your speakers list has been updated successfully',
            ]
        ]);
    }
}
