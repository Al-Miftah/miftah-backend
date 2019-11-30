<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicCollection;

class UserTopicController extends Controller
{
    /**
     * List all topics user is following
     */
    public function index()
    {
        $user = auth('api')->user();
        $topics = $user->topics()->paginate();
        return new TopicCollection($topics);
    }

    /**
     * Follow/Unfollow a topic
     */
    public function store(Request $request, Topic $topic)
    {
        $user = auth('api')->user();
        $topic->followers()->toggle($user->id);
        $topics = $user->topics()->paginate();
        return new TopicCollection($topics);
    }
}
