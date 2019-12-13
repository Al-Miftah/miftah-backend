<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use App\Http\Resources\SpeechCollection;

class SpeakerSpeechController extends Controller
{
    public function __invoke(Speaker $speaker)
    {
        $speeches = $speaker->speeches()->paginate();
        return new SpeechCollection($speeches);
    }
}
