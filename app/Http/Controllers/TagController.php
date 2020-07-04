<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;

class TagController extends Controller
{

    /**
     * List tags
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        return response()->json([
            'data' => Tag::get(['id', 'name'])
        ]);
    }

    /**
     * Create a new tag
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //Create tags
        $tags = $request->input('tags');
        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tag)],
                [
                    'name' => $tag,
                ]
            );
        }

        return response()->json([
            'message' => 'Tags created successfully!'
        ]);
    }


    /**
     * Update a tag
     *
     * @param Request $request
     * @param Tag $tag
     * @return void
     */
    public function update(Request $request, Tag $tag)
    {
        $tag->name = $request->name;
        $tag->save();
        return new TagResource($tag);
    }


    /**
     * Delete a tag
     *
     * @param Tag $tag
     * @return void
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->noContent();
    }
}
