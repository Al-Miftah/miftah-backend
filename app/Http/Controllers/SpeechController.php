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
        if ($request->permanent) {
            $speech->forceDelete();
        }else {
            $speech->delete();
        }
        return response()->noContent(204);
    }
}
