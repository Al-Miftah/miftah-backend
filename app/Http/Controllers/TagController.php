<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::paginate(30);

        return new TagCollection($tags);
    }

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


    public function update(Request $request, Tag $tag)
    {
        $tag->name = $request->name;
        $tag->save();
        return new TagResource($tag);
    }


    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->noContent();
    }
}
