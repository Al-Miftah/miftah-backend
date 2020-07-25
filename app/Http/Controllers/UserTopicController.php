<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserTopicController extends Controller
{
    /**
     * List users
     *
     * @return TopicCollection
     */
    public function index()
    {
        $user = auth('api')->user();
        $topics = $user->topics()->paginate();
        return new TopicCollection($topics);
    }

    /**
     * Toggle following Topic
     *
     * @param Request $request
     * @param Topic $topic
     * @return TopicCollection
     */
    public function store(Request $request, Topic $topic)
    {
        $user = auth('api')->user();
        $topic->followers()->toggle($user->id);
        $topics = $user->topics()->paginate();
        return new TopicCollection($topics);
    }
}
