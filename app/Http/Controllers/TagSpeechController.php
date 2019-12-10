<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpeechCollection;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagSpeechController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Tag $tag)
    {
        $speeches = $tag->speeches()->paginate();
        return new SpeechCollection($speeches);
    }
}
