<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use App\Http\Resources\SpeakerCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserSpeakerController extends Controller
{
    /**
     * List speakers user is following
     *
     * @param Request $request
     * @param Speaker $speaker
     * @return SpeakerCollection
     */
    public function index(Request $request, Speaker $speaker)
    {
        $user = auth('api')->user();
        $speakers = $user->speakers()->paginate();
        return new SpeakerCollection($speakers);
    }

    /**
     * Toggle following a speaker
     *
     * @param Request $request
     * @param Speaker $speaker
     * @return \Illuminate\Http\Response
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
