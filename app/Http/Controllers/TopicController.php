<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;


class TopicController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::get(['id', 'title', 'description']);
        return response()->json([
            'data' => $topics
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Create Topic', 'api'), 403);
        $topic = Topic::create($request->only('title', 'description'));
        return new TopicResource($topic);
    }

    /**
     * View a topic
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request, Topic $topic)
    {
        return new TopicResource($topic->load('speeches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Update Topic', 'api'), 403);
        $topic->update($request->only(['title', 'description']));
        return new TopicResource($topic->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Topic $topic)
    {   $admin = auth('api')->user();
        abort_unless($admin->can('Delete Topic', 'api'), 403);
        $topic->delete();
        return response()->noContent(204);
    }
}
