<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Speech;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\SpeechResource;
use App\Http\Resources\SpeechCollection;
use App\Http\Requests\StoreSpeechRequest;
use App\Http\Requests\UpdateSpeechRequest;

class SpeechController extends Controller
{
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * List speeches
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $speeches = Speech::paginate(10);
        return new SpeechCollection($speeches);
    }


    /**
     * Create a new speech
     *
     * @param StoreSpeechRequest $request
     * @return void
     */
    public function store(StoreSpeechRequest $request)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Create Speech', 'api'), 403);

        $input = $request->only(['title', 'summary', 'transcription', 'cover_photo', 'url', 'speaker_id', 'topic_id']);
        $speech = new Speech($input);
        $speech->save();

        //Tags if any
        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $ids = [];

            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['slug' => Str::slug($tag)], [
                    'name' => $tag
                ]);
                $ids[] = $tag->id;
            }

            $speech->tags()->syncWithoutDetaching($ids);
        }

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'Speech created successfully'
            ]
        ], 201);
    }

    /**
     * Show details of a speech
     *
     * @param Speech $speech
     * @return void
     */
    public function show(Speech $speech)
    {
        $data = $speech->load('speaker', 'tags');
        return new SpeechResource($data);
    }


    /**
     * Update speech
     *
     * @param UpdateSpeechRequest $request
     * @param Speech $speech
     * @return void
     */
    public function update(UpdateSpeechRequest $request, Speech $speech)
    {
        $admin = auth('api')->user();
        abort_unless($admin->can('Update Speech', 'api'), 403);

        $input = $request->only('title', 'summary', 'transcription', 'speaker_id', 'topic_id');
        $speech->update($input);
        //Tags if any
        if ($request->has('tags')) {
            $tags = $request->input('tags');
            $ids = [];

            foreach ($tags as $tag) {
                $tag = Tag::firstOrCreate(['slug' => Str::slug($tag)], [
                    'name' => $tag
                ]);
                $ids[] = $tag->id;
            }

            $speech->tags()->syncWithoutDetaching($ids);
        }

        return new SpeechResource($speech->fresh());
    }

    /**
     * Delete a speech
     *
     * @param Request $request
     * @param Speech $speech
     * @return void
     */
    public function destroy(Request $request, Speech $speech)
    {
        $admin = auth('api')->user();

        if ($request->permanent) {
            abort_unless($admin->can('Force delete Speech'), 403);
            $speech->forceDelete();
        }else {
            abort_unless($admin->can('Delete Speech', 'api') || $admin->can('Force delete Speech', 'api'), 403);
            $speech->delete();
        }
        return response()->noContent(204);
    }
}
